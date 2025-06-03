<?php

namespace App\Http\Controllers;

use App\AddressMultiple;
use App\Agreement;
use App\AgreementTermsAndCondition;
use App\Categorie;
use App\Category;
use App\Clients;
use App\Order;
use App\ServiceAgreement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use App\PasswordReset;
use App\Models\EmailSubject;
use App\Models\EmailTemplate;
use App\Mail\UserPassResetShopMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\ClientCreditCard;
use App\Industry;
use App\PageSettings;
use App\TermsAndCondition;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;

class ServiceAgreementController extends Controller {

    public function __construct()
    {
        Session::put('tab', 'client_info');
       // $this->middleware('auth:profile', ['except' => 'checkout', 'cashondelivery']);

        $this->middleware('auth')->only(
            'getAllAgreement',
            'createAgreement',
            'storeAgreement',
            'editAgreement',
            'updateAgreement',
            'destroyAgreement',
            'getAllTermsAndConditions',
            'createCondition',
            'storeCondition',
            'editCondition',
            'updateCondition',
            'destroyCondition',
            'duplicateCondition',
            'getConditionSearchResults');
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
        // $terms_and_conditions=$page->terms_and_conditions;
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

            $agreement = Agreement::with('agreementTermsAndConditions')->where('is_default', true)->first();
            $condition_list = [];
            if ($agreement) {

                foreach ($agreement->agreementTermsAndConditions as $condition) {
                    if ($condition->is_active) {
                        $termsAndCondition = TermsAndCondition::where('status', 'active')->find($condition->terms_and_condition_id);
                        if ($termsAndCondition) {
                            array_push($condition_list, $termsAndCondition);
                        }
                    }
                }
            }

            $terms_and_conditions=$condition_list;
            return view('home.service-agreements', compact('user', 'customer','documents', 'order','order_details','card_details','terms_and_conditions','client_information','credit_card_infromation','agreement'));
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
            'billing_address_1' => 'required',
            'billing_city'    => 'required',
            'billing_postal_code'    => 'required',            
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
        $order->customer_name = $request->contact_name;
        $order->customer_email = $request->email;
        $order->customer_phone = $request->phone_number;
        $order->shipping_city = $request->shipping_city;
        $order->customer_city = $request->shipping_city;
        $order->make_it_count = $request->make_it_count;
        $order->update();
        
        $client_id = $request->user_id;
        $client = Clients::find($client_id);

        $client->business_name = $request->company_name;
        $client->name = $request->contact_name;
        $client->phone = $request->phone_number;
        $client->email = $request->email;
        $client->address = $request->billing_address_1;
        $client->Province_State = $request->billing_state;
        $client->zip = $request->billing_postal_code;
        $client->city = $request->billing_city;
        $client->save();

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


         $client = Clients::where('email', $client->email)->first();

         if ($client->is_activated) 
        {
           Auth::guard('profile')->login($client); // No password needed

           if(Auth::guard('profile')->check())
           {
             return redirect('/shop-documents-list')->with('message', 'Completed Document Successfully');
           }
           
        }
         else {
          
            $token = str_random(20);
            PasswordReset::create([
                'user_id' => $client->id,
                'token' => $token,
                'created_at' => Carbon::now(),
                'expired_at' => date("Y-m-d H:i:s", strtotime("+15 minutes"))
            ]);
            $EmailSubject = EmailSubject::where('token', 'c4jkpk69')->first();
            $EmailTemplate = EmailTemplate::where('domain', 2)->where('subject_id', $EmailSubject['id'])->first();
            Mail::to($client->email)->send(new UserPassResetShopMail($token, $EmailSubject['subject'], $EmailTemplate));

            Cookie::queue('redirect_shop', '/shop-documents-list', 60); // lasts 60 minutes

            return redirect('/shop-signin')->with('message','Please check your email and reset your password to log in.');   

         }

 
      
    }


    public function getAllAgreement(Request $request)
    {
        $greement_list = Agreement::all();
        return view('admin.service_agreement_list', compact('greement_list'));
    }

      public function createAgreement()
    {
        $condition_list = TermsAndCondition::where('status', 'active')->get();
        return view('admin.agreement_create', compact('condition_list'));
    }

    public function storeAgreement(Request $request){

        if (empty($request->condition_list) || count($request->condition_list) == 0) {
            return redirect()->back()->with('message-error', 'Please select at least one condition.');
        }

 
        $request->validate([
            'name' => 'required',
            'content' => 'required'
        ]);

        $agreement = new Agreement();
        $agreement->name = $request->name;
        $agreement->content = $request->content;

        if($request->is_default == true){
            $is_default_agreement= Agreement::where('is_default',true)->first();
            if($is_default_agreement == true){
                $is_default_agreement->is_default = false;
                $is_default_agreement->save();
            }
            $agreement->is_default = true;
        }
        $agreement->save();


        $condition_list = TermsAndCondition::where('status', 'active')->get();

        foreach ($condition_list as $key => $condition) {
            $agreementTermsAndCondition = new AgreementTermsAndCondition();
            $agreementTermsAndCondition->agreement_id = $agreement->id;
            $agreementTermsAndCondition->terms_and_condition_id = $condition->id;

            foreach ($request->condition_list as $k => $value) {
                if($condition->id == $value){
                    $agreementTermsAndCondition->is_active = true;

                }else{
                    $agreementTermsAndCondition->is_active = false;
                }
            }
            $agreementTermsAndCondition->save();
        }

        return redirect('/admin/agreement_list')->with('message', 'Service Agreement created successfully.');
    }

    public function editAgreement($id)
    {
        $agreement = Agreement::with('agreementTermsAndConditions')->findOrFail($id);

        $condition_list = TermsAndCondition::where('status', 'active')->get();

        // Build a list of all conditions, marking those that are active in the agreement
        $condition_list_array = [];

        foreach ($condition_list as $condition) {
            // Find if this condition is already attached to the agreement
            $existing = $agreement->agreementTermsAndConditions
                ->where('terms_and_condition_id', $condition->id)
                ->first();

            $condition_list_array[] = [
                'agreement_id' => $agreement->id,
                'terms_and_condition_id' => $condition->id,
                'terms_and_condition_name' => $condition->name,
                'terms_and_condition_title' => $condition->title,
                'is_active' => $existing ? $existing->is_active : false,
            ];
        }
        return view('admin.agreement_edit', compact('agreement', 'condition_list_array'));
    }


    public function updateAgreement(Request $request){
        $conditionList = $request->input('condition_list', []);
        if (empty($conditionList) || count($conditionList) == 0) {
            return redirect('/admin/agreement/edit/'.$request->id)->with('message-error', 'Please select at least one condition.');
        }

        $request->validate([
            'name' => 'required',
            'content' => 'required'
        ]);

        $agreement = Agreement::find($request->id);
        $agreement->name = $request['name'];
        $agreement->content = $request['content'];
        if($request->is_default == true){
            $is_default_agreement= Agreement::where('is_default',true)->first();
            if($is_default_agreement == true){
                $is_default_agreement->is_default = false;
                $is_default_agreement->save();
            }
            $agreement->is_default = true;
        }
        $agreement->save();

        
        $agreementTermsAndConditions = AgreementTermsAndCondition::where('agreement_id', $agreement->id)->get();
        $agreementTermsAndConditions->each(function ($item) {
            $item->delete();
        });

        $condition_list = TermsAndCondition::where('status', 'active')->get();

        foreach ($condition_list as $key => $condition) {
            $agreementTermsAndCondition = new AgreementTermsAndCondition();
            $agreementTermsAndCondition->agreement_id = $agreement->id;
            $agreementTermsAndCondition->terms_and_condition_id = $condition->id;

            $agreementTermsAndCondition->is_active = in_array($condition->id, $request->condition_list);
            $agreementTermsAndCondition->save();
        }

        return redirect('/admin/agreement_list')->with('message', 'Service Agreement updated successfully.');
    }

    public function destroyAgreement(Request $request, $id)
    {
        $request->validate([
            'id' => 'required',
        ]);


        $agreementTermsAndConditions = AgreementTermsAndCondition::where('agreement_id', $request->id)->get();
        $agreementTermsAndConditions->each(function ($item) {
            $item->delete();
        });

        Agreement::where('id', $id)->delete();

        return redirect('/admin/agreement_list')->with('message', 'Service Agreement deleted successfully.');
    }

    public function getAllTermsAndConditions(Request $request)
    {
        $category_list = Category::get();
        $industry_list = Industry::get();
        $condition_list = TermsAndCondition::with('category','industry')->get();
        return view('admin.terms and_conditions_list', compact('condition_list','category_list','industry_list'));
    }

    public function createCondition()
    {
        $category_list = Category::get();
        $industry_list = Industry::get();
        return view('admin.condition_create', compact('category_list','industry_list'));
    }

    public function storeCondition(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'categorie_id' => 'required',
            'industry_id' => 'required',
        ]);

        $condition = new TermsAndCondition();
        $condition->name = $request->name;
        $condition->title = $request->title;
        $condition->categorie_id = $request->categorie_id;
        $condition->status = $request->status ?? 'active';
        $condition->industry_id = $request->industry_id;
        $condition->save();
        return redirect('/admin/terms_conditions_list')->with('message', 'Terms and Conditions created successfully.');
    }
    
    public function editCondition($id)
    {
        $condition = TermsAndCondition::findOrFail($id);
        $category_list = Category::get();
        $industry_list = Industry::get();
        return view('admin.condition_edit', compact('condition','category_list','industry_list'));
    }

    public function duplicateCondition($id)
    {
        $condition = TermsAndCondition::findOrFail($id);

        // Duplicate the condition
        $newCondition = $condition->replicate();
        $newCondition->name = $condition->name;
        $newCondition->save();

        return redirect('/admin/terms_conditions_list')->with('message', 'Terms and Conditions duplicated successfully.');
    }

    public function updateCondition(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'title' => 'required',
            'categorie_id' => 'required',
            'industry_id' => 'required',
        ]);

        $condition = TermsAndCondition::findOrFail($request->id);
        $condition->title = $request->title;
        $condition->name = $request->name;
        $condition->categorie_id = $request->categorie_id;
        $condition->industry_id = $request->industry_id;  
        $condition->status = $request->status;      
        $condition->save();
        return redirect('/admin/terms_conditions_list')->with('message', 'Terms and Conditions updated successfully.');

    }


    public function destroyCondition(Request $request, $id)
    {
        // Validate the ID exists in the table
        $request->validate([
            'id' => 'required',
        ]);

        // Check if the condition is used in any agreement and is active
        $agreementTerm = AgreementTermsAndCondition::where('terms_and_condition_id', $id)->first();

        if ($agreementTerm && $agreementTerm->is_active) {
            return redirect('/admin/terms_conditions_list')->with('error', 'Cannot delete this condition as it is used in an agreement.');
        }
        // Remove related agreement terms and the condition itself
        AgreementTermsAndCondition::where('terms_and_condition_id', $id)->delete();
        TermsAndCondition::where('id', $id)->delete();

        return redirect('/admin/terms_conditions_list')->with('message', 'Terms and Conditions deleted successfully.');
    }

    public function getConditionSearchResults(Request $request)
    {
        $query = TermsAndCondition::query();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('id', $search);
            });
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->where('categorie_id', $category);
        }

        // Filter by industry
        if ($industry = $request->input('industry')) {
            $query->where('industry_id', $industry);
        }

        // Filter by status (assuming 'status' is a column, e.g., active/inactive)
        if (!is_null($request->input('status'))) {
            $query->where('status', $request->input('status'));
        }

        // Filter by ID
        if ($id = $request->input('id')) {
            $query->where('id', $id);
        }


        $category_list = Category::get();
        $industry_list = Industry::get();
        $condition_list = $query->with('category','industry')->get();

        return view('admin.terms and_conditions_list', compact('condition_list','category_list','industry_list'));

    }
    
}
