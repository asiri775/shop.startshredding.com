<?php

namespace App\Http\Controllers;

use App\AddressMultiple;
use App\Clients;
use App\Order;
use App\ServiceAgreement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\ClientCreditCard;
use App\PageSettings;

class ServiceAgreementController extends Controller {

    public function __construct()
    {
        Session::put('tab', 'client_info');
       // $this->middleware('auth:profile', ['except' => 'checkout', 'cashondelivery']);
    }

    public function view($id) {
       
        $user = Clients::find(Auth::user()->id);

        $order = Order::findOrFail($id);

        $page = PageSettings::findOrFail(1);
        $userAddressSplitted = explode(", ", $order->customer_address, 1); 
        $shippingAddressSplitted = $order->shipping_address? 
            explode(", ", $order->shipping_address, 1): $userAddressSplitted;
        $terms_and_conditions=$page->terms_and_conditions;
        // Filling with default values if not exist a service agreement for a order
        $serviceAgreement = ServiceAgreement::firstOrCreate([
            "company_name" => $user->business_name ? $user->business_name : "",
            "contact_name" => $user->name,
            "phone_number" => $user->phone,
            "email" => $user->email,
            "billing_address_1" => $userAddressSplitted[0],
            "billing_address_2" => count($userAddressSplitted)>1? $userAddressSplitted[1] : "",
            "billing_city" => $order->customer_city,
            "billing_state" => $user->Province_State,
            "billing_postal_code" => $order->customer_zip,
            "billing_phone" => $order->customer_phone,
            "billing_email" => $order->customer_email,
            "shipping_address_1" => $shippingAddressSplitted[0],
            "shipping_address_2" => count($shippingAddressSplitted)>1? $shippingAddressSplitted[1] : "",
            "shipping_city" => $order->shipping_city ? $order->shipping_city: $order->customer_city,
            "shipping_state" => "",
            "shipping_postal_code" => $order->shipping_zip? $order->shipping_zip: $order->customer_zip,
            "shipping_phone" => $order->shipping_phone ? $order->shipping_phone : $order->customer_phone,
            "shipping_email" => $order->shipping_email ? $order->shipping_email : $order->customer_email,
        ],[
            "order_id" => $order->getKey(),
        ]);


        return view('new_pages.service_agreement',compact('user','order', 'serviceAgreement','terms_and_conditions'));
    }

    public function save_sign()
    {
        $img = $_POST['image'];
        $client_name = $_POST['client_name'];
        $order_id = $_POST['order_id'];
        $img = str_replace('data:image/jpeg;base64,', '', $img);   
        $img = str_replace(' ', '+', $img);   
        $data = base64_decode($img);

        if(!file_exists($_SERVER['DOCUMENT_ROOT'] . "/photos"))
        {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/photos");      
        }
        
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/photos/".$order_id.'.jpg'))
        {
            unlink($_SERVER['DOCUMENT_ROOT'] . "/photos/".$order_id.'.jpg');
        }
        $success = file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/photos/".$order_id.'.jpg', $data);
        return $success?json_encode('Save successfully'):json_encode("Unable to save the image");
    }

    public function complete_sa(Request $request)
    {
        
        // $serviceAgreement = ServiceAgreement::where('order_id', $request->order_id);
        // $serviceAgreement->fill($request->all());
        // $serviceAgreement->sa_state = '1';
        // $serviceAgreement->update();
        $order = Order::find($request->order_id);
        $order->token = "";
        $order->update();
        $serviceAgreement = ServiceAgreement::updateOrCreate(['order_id' => $request->order_id]);
        $serviceAgreement->fill($request->all());
        $serviceAgreement->sa_state = '1';
        $serviceAgreement->update();
        return redirect('/shop-documents-list')->with('message', 'Completed Document Successfully');
    }

    public function completeStepOne(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'name'     => 'required|min:3',
            'email'    => 'required|email',
            'password' => 'required|min:6',
            'address'  => 'required',
            'city'     => 'required',
            'zip'      => 'required|digits:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // $order = Order::find($request->order_id);
        // $order->token = "";
        // $order->update();
        // $serviceAgreement = ServiceAgreement::updateOrCreate(['order_id' => $request->order_id]);
        // $serviceAgreement->fill($request->all());
        // $serviceAgreement->sa_state = '1';
        // $serviceAgreement->update();

    }


    public function confirm_link($token, Request $request)
    {
        $page = PageSettings::findOrFail(1);
        //print_r($token); die;
        if (! $request->hasValidSignature()) {
            return ("The link is expired");
        }
        $data = json_decode(Crypt::decryptString($token), true);

        //print_r($data); die;

        $user = Clients::find($data['user_id']);
        $customer = Clients::find($user->id);
        $order = Order::find($data['order_id']);
        $terms_and_conditions=$page->terms_and_conditions;
        $client_information=$page->client_information;
        $credit_card_infromation=$page->credit_card_infromation;
        if($token == $order->token){
            $documents = ServiceAgreement::where('order_id', $order->id)->first();
        
        
            $order_details =DB::table('ordered_products')
                            ->join('products', 'products.id', '=', 'ordered_products.productid')
                            ->select('ordered_products.*','products.title')
                            ->where('ordered_products.orderid', $order->id)
                            ->get();
            $card_details = ClientCreditCard::where('client_id', $user->id)->get();
            
            return view('home.service-agreements', compact('user', 'customer','documents', 'order','order_details','card_details','terms_and_conditions','client_information','credit_card_infromation'));
        }
        else {
            return "You have alreday confirmed the Service Agreement";
        }
    }


    public function showForm($token, Request $request)
    {

         $documents='';
         $order_details='';
         $card_details='';
         $page = PageSettings::findOrFail(1);
        //print_r($token); die;
        // if (! $request->hasValidSignature()) {
        //     return ("The link is expired");
        // }
        $data = json_decode(Crypt::decryptString($token), true);

        //print_r($data); die;

        $user = Clients::find($data['user_id']);
        $customer = Clients::find($user->id);
        $order = Order::find($data['order_id']);
        $terms_and_conditions=$page->terms_and_conditions;
        $client_information=$page->client_information;
        $credit_card_infromation=$page->credit_card_infromation;
        if($token == $order->token){
            $documents = ServiceAgreement::where('order_id', $order->id)->first();
        
        
            $order_details =DB::table('ordered_products')
                            ->join('products', 'products.id', '=', 'ordered_products.productid')
                            ->select('ordered_products.*','products.title')
                            ->where('ordered_products.orderid', $order->id)
                            ->get();
            $card_details = ClientCreditCard::where('client_id', $user->id)->get();
        }

        return view('home.form-wizard', compact('user', 'customer','documents', 'order','order_details','card_details','terms_and_conditions','client_information','credit_card_infromation'));
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'company_name'  => 'required',
            'contact_name'    => 'required',
            'phone_number'  => 'required',
            // 'email'=>'required',
            'billing_address_1' => 'required',
            // 'billing_address_2'  => 'required',
            'billing_city'    => 'required',
            // 'billing_state'  => 'required',
            'billing_postal_code'    => 'required',            
            // 'shipping_address_1' => 'required',
            // 'shipping_address_2'  => 'required',
            // 'shipping_city' => 'required',
            // 'shipping_state'=> 'required',
            // 'shipping_postal_code'=> 'required',
            // 'shipping_phone'=> 'required',
          //'pick_up_date'=> 'required',
            'operation_from'=> 'required', 
            'operation_to'=> 'required',
            'terms_accepted'=> 'required',
            'credit_card_name'=> 'required',
            'credit_card_number'=> 'required',
            'credit_card_expire_month'=> 'required',
            'credit_card_expire_year'=> 'required',
            'credit_card_ccv'=> 'required',
            'signature'=>'required',
        ]);
      
        $serviceAgreement = ServiceAgreement::updateOrCreate(['order_id' => $request->order_id]);
        $serviceAgreement->fill($request->all());
        $serviceAgreement->sa_state = 1;
        $serviceAgreement->update();

        
        $order = Order::find($request->order_id);
        $order->make_it_count = $request->make_it_count;
        // echo '<pre>';
        // print_r($order); die;

        //$order->token = "";
        $order->update();
        
        $client_id = $request->user_id;
        $client = Clients::find($client_id);

        if ($client && is_null($client->Province_State)) {
            $client->update([
                'Province_State' => $serviceAgreement->billing_state,
            ]);
        }

        $existingCard = ClientCreditCard::where('client_id', $client_id)
            ->where('card_number', $request->credit_card_number)
            ->first();

        if (!$existingCard) {
            $credit = new ClientCreditCard;
            $credit['client_id'] = $client_id;
            $credit['card_holder_name'] = $request->credit_card_name;
            $credit['card_number'] = $request->credit_card_number;
            $credit['exp_month'] = $request->credit_card_expire_month;
            $credit['exp_year'] = $request->credit_card_expire_year;
            $credit['ccv'] = $request->credit_card_ccv;
    
            $is_primary = ClientCreditCard::where('client_id', $client_id)->count();
            $credit['is_primary'] = $is_primary == 0 ? '1' : '0';
    
            $credit->save();
        }

        return redirect('/shop-documents-list')->with('message', 'Completed Document Successfully');
    }
    
}
