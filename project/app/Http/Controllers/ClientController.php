<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\UserProfile;
use App\AddressMultiple;
use App\Clients;
use App\Mail\UserRegistrationMail;
use App\Models\EmailSubject;
use App\Models\EmailTemplate;
use App\Mail\UserRegisterVerification;
use App\VendorCustomers;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    public function getAJAXClient(Request $request)
    {
        $input = $request->all();
        $client_id = $input['client_id'];
        $client = DB::table('clients')
            ->when($client_id, function ($client) use ($client_id) {
                return $client->where('id', '=', '' . $client_id . '');
            })
            ->where('id', '<>', '')
            ->first();
        echo json_encode($client);
    }

    public function getAJAXSearchClient(Request $request)
    {
        $input = $request->all();
        DB::enableQueryLog();
        $keyword = empty($input['keyword']) ? "" : $input['keyword'];
        $phone = empty($input['phone']) ? "" : $input['phone'];
        $clients = DB::table('vendor_customers')
            ->when($keyword, function ($clients) use ($keyword) {
                return $clients->where('business_name', 'LIKE', '%' . $keyword . '%');
            })
            ->when($keyword, function ($clients) use ($keyword) {
                return $clients->orWhere('name', 'LIKE', '%' . $keyword . '%');
            })
            ->when($phone, function ($clients) use ($phone) {
                return $clients->where('phone', 'LIKE', '%' . $phone . '%');
            })
            ->where('vendor_id', '=', Auth::user()->id)
            ->where('status', '=', 1)
            ->distinct()
            ->orderBy('name')
            ->get();

        if (count($clients) > 0) {
            echo '<div class="tableDescription">Select a profile to edit</div>';
            echo '<table class="table table-striped table-bordered table-hover" id="searchClientResult">';
            echo "<thead class='res-tbl-head'>";
            echo "<tr>";
            echo "<th class='text-center'>#</td>";
            echo "<th class='text-center'>Customer Name</td>";
            echo "<th class='text-center'>Business Name</td>";
            echo "<th class='text-center'>Phone</th>";
            echo "<th class='text-center'><i class='fa fa-edit'></i></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $i = 1;
            foreach ($clients as $client) {
                echo '<tr class="client" data-id="' . $client->customer_id . '">';
                echo '<td>' . $i . '</td>';
                echo '<td>' . trim($client->name) . '</td>';
                echo '<td>' . trim($client->business_name) . '</td>';
                echo '<td>' . trim($client->phone) . '</td>';
                echo '<td class="vCenter" align="center"><button style="padding: 2px 5px;" class="btn btn-success js-edit_client_button" data-id="' . $client->customer_id . '" onclick="openEditPopup(' . $client->customer_id . ');"><i class="fa fa-edit"></i></button></td>';
                echo '</tr>';

                $i++;
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No results found";
        }
    }

    public function customerAdd(Request $request)
    {
        $input = $request->all();
        $fname = $input['first_name'];
        $lname = $input['last_name'];
        $phone = $input['phone1'] . $input['phone2'] . $input['phone3'];
        $email = empty($input['email']) ? "" : $input['email'];
        $address = empty($input['address']) ? "" : $input['address'];
        $country = empty($input['country']) ? "" : $input['country'];
        $city = empty($input['city']) ? "" : $input['city'];
        $province = empty($input['province']) ? "" : $input['province'];
        $zip = $input['zip1'] . $input['zip2'];
        $longi = empty($input['lontude']) ? 0 : $input['lontude'];
        $lat = empty($input['latude']) ? 0 : $input['latude'];
        $business_name = empty($input['business_name']) ? "" : $input['business_name'];

        $department =  $input['department'];
        $payment_method = $input['payment_method'];
        $tax_group = $input['tax_group'];
        $source = $input['source'];
        $manager = $input['manager'];
        $customer_type = $input['customer_type'];
        $status = $input['status'];
        

        $user = Clients::create([
            'name' => $fname . ' ' . $lname,
            'first_name' => $fname,
            'last_name' => $lname,
            'phone' => $phone,
            'balance' => 0,
            'email' => $email,
            'password' => Hash::make(123),
            'address' => $address,
            'city' => $city,
            'Province_State' => $province,
            'Country' => $country,
            'zip' => $zip,
            'longitude' => $longi,
            'latitude' => $lat,
            'business_name' => $business_name,
            'customer_type' => $customer_type,
            'status' => $status,
            'department' => $department, // ToDo: new recods added
            'payment_method' => $payment_method,// ToDo: new recods added
            'TAX_GROUP' => $tax_group,// ToDo: new recods added
            'source' => $source,// ToDo: new recods added
            'Account_Manager' => $manager// ToDo: new recods added
        ]);

        if (!empty($input['address'])) {
            AddressMultiple::create([
                'user_id' => $user->id,
                'address_alias' => "Default",
                'address' => $address,
                'city' => $city,
                'zip' => $zip,
                'province' => $province,
                'longitude' => $longi,
                'latitude' => $lat,
            ]);
        }

        VendorCustomers::create([
            'vendor_id' => Auth::user()->id,
            'customer_id' => $user->id,
            'phone' => $phone,
            'name' => $fname . ' ' . $lname,
            'business_name' => $business_name,
            'status' => 1
        ]);

        return redirect()->back()
            ->with('message', 'Customer successfully added!');
    }

    public function customerUpdate(Request $request)
    {
        $input = $request->all();
        $client_id = $input['hf_client_id'];

        $business_name = empty($input['txt_business_name']) ? "" : $input['txt_business_name'];
        $first_name = $input['txt_first_name'];
        $last_name = $input['txt_last_name'];
        $name = $first_name . ' ' . $last_name;
        $email = $input['txt_email'];
        $phone = $input['txt_phone1'] . $input['txt_phone2'] . $input['txt_phone3'];
        $address = empty($input['txt_address']) ? "" : $input['txt_address'];
        $country = empty($input['txt_country']) ? "" : $input['txt_country'];
        $city = empty($input['txt_city']) ? "" : $input['txt_city'];
        $province = empty($input['cmb_province']) ? "" : $input['cmb_province'];
        $zip = $input['txt_fsa1'] . $input['txt_fsa2'];

        $qry = "";
        $qry .= "UPDATE clients set name='" . $name . "', first_name='" . $first_name . "', last_name='" . $last_name . "',";
        $qry .= " phone='" . $phone . "', email='" . $email . "', address='" . $address . "', city='" . $city . "',";
        $qry .= " Province_State='" . $province . "', Country='" . $country . "', zip='" . $zip . "', business_name='" . $business_name . "'";
        $qry .= " WHERE id = ?";
        $affected = DB::update($qry, [$client_id]);

        $qry1 = "";
        $qry1 .= "UPDATE multiple_address SET address='".$address."', city='".$city."', zip='".$zip."',";
        $qry1 .= "province='".$province."'";
        $qry1 .= " WHERE user_id = ? AND address_alias=?";
        $affected = DB::update($qry1, [$client_id, 'Default']);

        $qry2 = "";
        $qry2 .= "UPDATE vendor_customers set phone='".$phone."', name='".$name."', business_name='".$business_name."'";
        $qry2 .= "WHERE vendor_id=? AND customer_id = ?";
        $affected = DB::update($qry2, [Auth::user()->id, $client_id]);

        return redirect()->back()
            ->with('message', 'Customer successfully updated!');
    }
}
