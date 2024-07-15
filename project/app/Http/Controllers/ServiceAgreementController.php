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

class ServiceAgreementController extends Controller {

    public function __construct()
    {
        Session::put('tab', 'client_info');
        $this->middleware('auth:profile', ['except' => 'checkout', 'cashondelivery']);
    }

    public function view($id) {
        $user = Clients::find(Auth::user()->id);

        $order = Order::findOrFail($id);


        $userAddressSplitted = explode(", ", $order->customer_address, 1); 
        $shippingAddressSplitted = $order->shipping_address? 
            explode(", ", $order->shipping_address, 1): $userAddressSplitted;

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


        return view('new_pages.service_agreement',compact('user','order', 'serviceAgreement'));
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

    public function confirm_link($token, Request $request)
    {
        if (! $request->hasValidSignature()) {
            return ("The link is expired");
        }
        $data = json_decode(Crypt::decryptString($token), true);
        $user = Clients::find($data['user_id']);
        $customer = Clients::find($user->id);
        $order = Order::find($data['order_id']);
        
        if($token == $order->token){
            $documents = ServiceAgreement::where('order_id', $order->id)->first();
        
        
            $order_details =DB::table('ordered_products')
                            ->join('products', 'products.id', '=', 'ordered_products.productid')
                            ->select('ordered_products.*','products.title')
                            ->where('ordered_products.orderid', $order->id)
                            ->get();
            $card_details = ClientCreditCard::where('client_id', $user->id)->get();
            
            return view('home.service-agreements', compact('user', 'customer','documents', 'order','order_details','card_details'));
        }
        else {
            return "You have alreday confirmed the Service Agreement";
        }
    }
    
}
