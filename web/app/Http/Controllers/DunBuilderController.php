<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\BuilderDetail;
use App\Models\MailSmtpSetting;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Shopify\Clients\Graphql;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class DunBuilderController extends Controller
{
    public function BuilderDetailSave(Request $request){

        try {

                $dun_builder_detail = new BuilderDetail();
                $dun_builder_detail->wall_width = $request->wall_width;
                $dun_builder_detail->wall_height = $request->wall_height;
                $dun_builder_detail->wall_unit = $request->wall_unit;
                $dun_builder_detail->dun_width = $request->dun_width;
                $dun_builder_detail->dun_height = $request->dun_height;
                $dun_builder_detail->dun_unit = $request->dun_unit;
                $dun_builder_detail->show_measurement = $request->show_measurement;
                $dun_builder_detail->form_type = $request->form_type;
                $dun_builder_detail->shape = $request->shape;
                $dun_builder_detail->vertical_density = $request->vertical_density;
                $dun_builder_detail->horizontal_density = $request->horizontal_density;
                if($request->image){
                    $fileName = uniqid() . '_' . time() . '.jpg';
                    $storagePath = storage_path('app/builder-images');

                    // Create the directory if it doesn't exist
                    if (!is_dir($storagePath)) {
                        mkdir($storagePath, 0755, true);
                    }

                    // Define the full image path
                    $img = $storagePath . '/' . $fileName;

                    // Attempt to save the image
                    file_put_contents($img, file_get_contents($request->image));

                    // Create a URL to access the image
                    $img_name = asset('web/storage/app/builder-images/' . $fileName);
                    $dun_builder_detail->image = $img_name;
                }

                $dun_builder_detail->email = $request->email;
                $dun_builder_detail->unique_id = Str::random(10);
                $dun_builder_detail->save();


            $this->SendMail($dun_builder_detail);
            $data = [
                'success' => true,
                 'preview'=>$dun_builder_detail->unique_id,
                'message' => 'Builder Details Saved Successfully',
            ];
        } catch (\Exception $exception) {
            $data = [
                'error' => $exception->getMessage(),
                'success' => false
            ];
        }
        return response()->json($data);
    }


    public function BuilderDetailsRetrieve(Request $request)
    {

        try {
            if(isset($request->preview)) {
                $dun_builder_detail = BuilderDetail::where('unique_id', $request->preview)->first();
                if ($dun_builder_detail) {

                    $data = [
                        'success' => true,
                        'data' => $dun_builder_detail,

                    ];
                } else {
                    $data = [
                        'message' => 'No Record Found',
                        'success' => true
                    ];
                }
            }
            else {
                $data = [
                    'message' => 'No Record Found',
                    'success' => true
                ];
            }
        }catch (\Exception $exception){
            $data = [
                'error' => $exception->getMessage(),
                'success' => false
            ];
        }
        return response()->json($data);
    }


    public function index(Request $request)
    {
        $shop = getShop($request->get('shopifySession'));
        try {
            if ($shop) {
                $builder_details = BuilderDetail::query();


                if ($request->search) {
                    $builder_details = $builder_details->where('email', 'like', '%' . $request->search . '%')->orWhere('unique_id', 'like', '%' . $request->search . '%');
                }

                $builder_details = $builder_details->orderBy('id', 'Desc')->paginate(20);

                $data = [
                    'success' => true,
                    'data' => $builder_details,
                ];

            }
        } catch (\Exception $exception) {
            $data = [
                'error' => $exception->getMessage(),
                'success' => false
            ];
        }
        return response()->json($data);
    }

    public function MailSmtp(Request $request){
        $shop = getShop($request->get('shopifySession'));
        if($shop) {
            $mail_smtp = MailSmtpSetting::where('shop_id', $shop->id)->first();
            if ($mail_smtp) {
                $data = [
                    'data' => $mail_smtp
                ];
                return response()->json($data);
            }
        }
    }
    public function MailSmtpSettingSave(Request $request){
        $shop = getShop($request->get('shopifySession'));
        if($shop){
            $mail_smtp=MailSmtpSetting::where('shop_id',$shop->id)->first();

            if($mail_smtp==null){
                $mail_smtp=new MailSmtpSetting();
            }

            $mail_smtp->shop_id=$shop->id;
            $mail_smtp->smtp_host=$request->smtp_host;
            $mail_smtp->smtp_username=$request->smtp_username;
            $mail_smtp->smtp_password=$request->smtp_password;
            $mail_smtp->email_from=$request->email_from;
            $mail_smtp->from_name=$request->from_name;
            $mail_smtp->reply_to=$request->reply_to;
            $mail_smtp->smtp_type=$request->smtp_type;
            $mail_smtp->smtp_port=$request->smtp_port;
            $mail_smtp->subject=$request->subject;
            $mail_smtp->save();

            $data = [
                'message' => 'Mail SMTP Added Successfully',
                'data' => $mail_smtp
            ];
            return response()->json($data);
        }

    }

    public function testmail(){
        $dun_builder_detail=BuilderDetail::first();
        $this->SendMail($dun_builder_detail);
    }
    public function SendMail($dun_builder_detail){
        $user =Session::first();



        $mail_smtp=MailSmtpSetting::where('shop_id',$user->id)->first();
        if($mail_smtp) {

            Config::set('mail.mailers.smtp.host',isset($mail_smtp->smtp_host)?($mail_smtp->smtp_host):env('MAIL_HOST'));
            Config::set('mail.mailers.smtp.port',isset($mail_smtp->smtp_port)?($mail_smtp->smtp_port):env('MAIL_PORT'));
            Config::set('mail.mailers.smtp.username',isset($mail_smtp->smtp_username)?($mail_smtp->smtp_username):env('MAIL_USERNAME'));
            Config::set('mail.mailers.smtp.password',isset($mail_smtp->smtp_password)?($mail_smtp->smtp_password):env('MAIL_PASSWORD'));
            Config::set('mail.from.address',isset($mail_smtp->email_from)?($mail_smtp->email_from):env('MAIL_FROM_ADDRESS'));
            Config::set('mail.from.name',isset($mail_smtp->from_name)?($mail_smtp->from_name):'Dun wall');


            $details['to'] = $dun_builder_detail->email;
            $details['subject'] = $mail_smtp->subject;
            $details['wall_width'] = $dun_builder_detail->wall_width;
            $details['wall_height'] = $dun_builder_detail->wall_height;
            $details['wall_unit'] = $dun_builder_detail->wall_unit;
            $details['dun_width'] = $dun_builder_detail->dun_width;
            $details['dun_height'] = $dun_builder_detail->dun_height;
            $details['dun_unit'] = $dun_builder_detail->dun_unit;
            $details['form_type'] = $dun_builder_detail->form_type;
            $details['show_measurement'] = $dun_builder_detail->show_measurement;
            $details['shape'] = $dun_builder_detail->shape;
            $details['vertical_density'] = $dun_builder_detail->vertical_density;
            $details['horizontal_density'] = $dun_builder_detail->horizontal_density;
            $details['unique_id'] = $dun_builder_detail->unique_id;
            if($dun_builder_detail->email) {
                try {
                    Mail::to($dun_builder_detail->email)->send(new SendEmail($details));
                    $dun_builder_detail->is_email_failed=0;
                    $dun_builder_detail->email_error=null;
                    $dun_builder_detail->save();
                }catch (\Exception $exception){
                    dd($exception->getMessage());
                    $dun_builder_detail->is_email_failed=1;
                    $dun_builder_detail->email_error=json_encode($exception->getMessage());
                    $dun_builder_detail->save();
                    throw $exception;
                }

            }

        }
    }
}
