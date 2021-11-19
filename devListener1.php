<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use App\Traits\StoredProcedures;
use App\Traits\UtilityProcedures;
use App\Traits\FunctionalityProcedures;

use App\Exports\SMSDeliveryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use Config;
use DB;
use Log;
use Redirect;
use DateTime;
use DatePeriod;
use DateInterval;

class DevListener extends Controller {
    use StoredProcedures, UtilityProcedures, FunctionalityProcedures;

    private $password;
    private $username;
    private $url;

    public function __construct() {
        $this->password = 'B3gtO3QVamhoX2S/y10L4z85NZSu7n+YvPQwQw2J6Ic=';
        $this->username = '5cee319d482e5c54c1674123';
        $this->url      = 'https://app.onepagecrm.com/api/v3/'; 
    }

    public function devListener(Request $request) {
      

        //Get data oject
        $data = $request->all();

        //Check if empty
        if(!empty($data)) {

            //If action
            if($data['type'] == "action" && $data['secretkey'] == "Community!@#"){

            //test variable initialised as ignored
            $processed="started";

            //convet data to string 
            $mData = json_encode($data);
           

         
            //Add data and the next action to table 
            $testD = [
                "Data"            =>$mData,
                "text"            =>$processed,
                "data_time"  => \Carbon\Carbon::now()->toDateTimeString(),
            ];

            if($data['reason'] == "created") {

            $setData = DB::Table("test_table_listener")->insert($testD);
            }
            $processed="ignored";
            //Retrieve contact details using contact_id
            $contactdetails = json_decode($this->getSpecific('contacts', $data['data']['action']['contact_id']));

            //If result is not NULL
            if($contactdetails!=NULL){

                //Test contactdetails
                // $testD = [
                //     "Data"            =>"contactdetails",
                //     "text"            =>"contactdetails present",
                // ];
                // $setData = DB::Table("test_table_listener")->insert($testD);

                //Get string first_name
                $fname= $contactdetails->data->contact->first_name;



                        //Log first name
                        // $testD = [
                        //     "Data"            => $fname,
                        //     "text"            =>"first name",
                        // ];
                        // $setData = DB::Table("test_table_listener")->insert($testD);


                //Retrieve first five chars from string
                $result = substr($fname, 0, 5);

                //If first five chars are equal to XXXXX
                    if($result==="xxxxx"){

                //test variable updated to processed
                        $processed="XXXXX processed";

                        //Test xxxxx
                        // $testD = [
                        //     "Data"            =>"xxxxx WORKS",
                        //     "text"            =>"xxxxx ok",
                        //     "fname"            =>$fname,
                        // ];
                        // $setData = DB::Table("test_table_listener")->insert($testD);


                    //Check if next action is string TEST ACTION
                    // if(stripos($data['data']['action']['text'], "TEST ACTION") !== false ) {
                    //     if(strcmp($data['data']['action']['text'],"SEND ORIENTATION EMAIL")==0 || strcmp($data['data']['action']['text'],"SEND\u00a0ORIENTATION\u00a0EMAIL")==0) {
        
                    //     $processed="Test action processed";
                    //     //Test TEST ACTION
                    //     // $testD = [
                    //     //     "Data"            =>"TEST ACTION",
                    //     //     "text"            =>"TEST ACTION ok",
                    //     //     "fname"            =>$fname,
                    //     // ];
                    //     // $setData = DB::Table("test_table_listener")->insert($testD);


                    //     $todaydate      = \Carbon\Carbon::now()->toDateString();
                    //     $exactTime      = strtotime(\Carbon\Carbon::now()->addMinutes(15)->toDateTimeString());

                    //     $text = "ACTION PASSED ";

                    //     $mid=$data['data']['action']['id'];

                    //     // Curl to mark TEST ACTION as done
                    //     $url = Config::get('settings.ONEPAGE_URL')."actions/".$mid."/mark_as_done";
                    //     $ch  = curl_init( $url );
                    //     curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    //     curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    //     curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                    //     curl_setopt( $ch, CURLOPT_USERPWD, Config::get('settings.ONEPAGE_USER').":".Config::get('settings.ONEPAGE_PASS'));
                    //     curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );

                    //     $result = curl_exec($ch);
                    //     curl_close($ch);

                    //     // Set next action as TEST SUCCESSFULL
                    //     // $this->setNextAction($text, $data['data']['action']['contact_id'], $data['data']['action']['assignee_id'], $todaydate, 'date_time', '1', "RA", "dealmanage", "new", null, $exactTime);

                    // // $this->sendOrientationMail($contactdetails,$data);
                    
                    // }
                    
                    // else if(strcmp($data['data']['action']['text'],"TEST ORIENTATION")==0){
                        
                    //     $processed="Send orientation processed";

                    //     $todaydate      = \Carbon\Carbon::now()->toDateString();
                    //     $exactTime      = strtotime(\Carbon\Carbon::now()->addMinutes(15)->toDateTimeString());

                    //     $text = "ORIENTATION SUCCESSFULL";

                    //     $mid=$data['data']['action']['id'];

                    //     // Curl to mark TEST ACTION as done
                    //     $url = Config::get('settings.ONEPAGE_URL')."actions/".$mid."/mark_as_done";
                    //     $ch  = curl_init( $url );
                    //     curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    //     curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    //     curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                    //     curl_setopt( $ch, CURLOPT_USERPWD, Config::get('settings.ONEPAGE_USER').":".Config::get('settings.ONEPAGE_PASS'));
                    //     curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );

                    //     $result = curl_exec($ch);
                    //     curl_close($ch);

                    //     // Set next action as TEST SUCCESSFULL
                    //     $this->setNextAction($text, $data['data']['action']['contact_id'], $data['data']['action']['assignee_id'], $todaydate, 'date_time', '1', "RA", "dealmanage", "new", null, $exactTime);

                    //     // $this->sendOrientationMail($contactdetails,$data);

                     
                    // }


    
                    // Check if next action is string TEST ACTION

                    // if(stripos($data['data']['action']['text'], "TEST ACTION") !== false ) {

                        $json_response = json_encode($data);
                $joinAccount   = $this->isJointAccount($data['data']['action']['text']);
                $action = [
                    "type"            => $data['type'],
                    "entity_id"       => $data['data']['action']['id'],
                    "reason"          => $data['reason'],
                    "timestamp"       => \Carbon\Carbon::createFromTimestamp($data['timestamp'])->toDateTimeString(),
                    "contact_id"      => $data['data']['action']['contact_id'],
                    "assignee_id"     => $data['data']['action']['assignee_id'],
                    "text"            => $data['data']['action']['text'],
                    "done"            => $data['data']['action']['done'],
                    "joint_account"   => $joinAccount,
                    "name"            => ($joinAccount == true ) ? $this->getJointName($data['data']['action']['text']) : null,
                    "date_to_process" => \Carbon\Carbon::createFromTimestamp($data['timestamp'])->toDateTimeString(),
                    "jsonlog"         => $json_response
                ];

                if (array_key_exists('exact_time', $data['data']['action'])) {
                    $action ['date_to_process'] = \Carbon\Carbon::createFromTimestamp($data['data']['action']['exact_time'])->toDateTimeString();
                } else {
                    if(array_key_exists('date', $data['data']['action'])) {
                      $action['date_to_process'] = \Carbon\Carbon::parse($data['data']['action']['date'])->addHours(8)->toDateTimeString();
                    }
                }

                if($data['data']['action']['text'] == "SEND CONSULTATION LINK" || $data['data']['action']['text'] == "SEND CONSULTATION EMAIL") {
                
                    $contactdetails = json_decode($this->getSpecific('contacts', $data['data']['action']['contact_id']));

                    if(!empty($contactdetails->data->contact)) :
                        $contactData     = $contactdetails->data->contact;
                        $type           = $data['data']['action']['text'];

                        $todaydate      = \Carbon\Carbon::now()->toDateString();
                        $exactTime      = strtotime(\Carbon\Carbon::now()->addMinutes(15)->toDateTimeString());

                        $callback = '';

                        foreach ($contactData->custom_fields as $callbackkey => $callbackvalue) :
                            if($callbackvalue->custom_field->id == "5dd7d6299b79b2364732fe83") :
                                 $callback  = $callbackvalue->value;
                            endif;
                        endforeach;

                        if(strlen($callback) < 1 ) :
                            $text = "FAILED ".$data['data']['action']['text']." - NO TIEBACK";
                            $this->updateAction($data['data']['action']['id']);

                            $this->setNextAction($text, $data['data']['action']['contact_id'], $data['data']['action']['assignee_id'], $todaydate, 'date_time', '1', "RA", "dealmanage", "new", null, $exactTime);

                            $this->setNotes($data['data']['action']['contact_id'], $text, $todaydate, $dealid = "", $userid=["5c78e2e4482e5c69ab60a2d2","5c9876cd482e5c5cd55b96ea"]);
                            
                        endif;
                           
                    endif;

                }

             
                        $s=$data['data']['action']['text'];
                        $s1= substr($s,0,31);

                        if(strcmp($s1,"SEN1 KNOWLEDGE CLUB CERTIFICATE")==0 && $data['reason'] == "created") {


                        $todaydate      = \Carbon\Carbon::now()->toDateString();
                        $exactTime      = strtotime(\Carbon\Carbon::now()->addMinutes(15)->toDateTimeString());
                        
                        $m_club=$this->r_value($contactdetails,"6058a9b3cb52e66be96f92a6");
                        if($m_club==1){

                        $text="FAILED TO SEND CLUB CERTIFICATE - CERTIFICATE NOT PRESENT";
                        // Set next action as TEST SUCCESSFULL
                        $this->setNextAction($text, $data['data']['action']['contact_id'], $data['data']['action']['assignee_id'], $todaydate, 'date_time', '1', "RA", "dealmanage", "new", null, $exactTime);

                        }else{

                            $n_action=$data['data']['action']['text'];
                            $cert = substr($n_action, 34); 
                            $text="NOT EQUAL";
                            $c1=strtoupper($m_club);

                            if($c1==$cert){
                                $text="ARE EQUAL";

                                if($data['reason'] == "updated" || $data['reason'] == "completed") {
                                    $checkaction = DB::Table("changelogs")
                                                        ->where("entity_id",$data['data']['action']['id'])
                                                        ->count();
                                    if($checkaction > 0) {
                                        $updatesms = DB::Table("changelogs")
                                                        ->where("entity_id",$data['data']['action']['id'])
                                                        ->update($action);
                
                                       //  Log::info(' AT '.\Carbon\Carbon::now().' RESPONSE FROM UPDATE RECORD TO CHANGELOGS ('.$updatesms.')');
                
                                    }else {
                                        $setSms = DB::Table("changelogs")->insert($action);
                                       // Log::info(' AT '.\Carbon\Carbon::now().' RESPONSE FROM NEW RECORD(UPDATE FAIL) TO CHANGELOGS ('.$setSms.')');
                                    }
                                                      
                                }
                                else {
                                    $setSms = DB::Table("changelogs")->insert($action);
                                     // Log::info(' AT '.\Carbon\Carbon::now().' RESPONSE FROM NEW RECORD TO CHANGELOGS ('.$setSms.')');
                                }
                            }else{

                                $text="FAILED TO SEND CLUB CERTIFICATE - CERTIFICATE NOT SAME";
                                // Set next action as TEST SUCCESSFULL
                                $this->setNextAction($text, $data['data']['action']['contact_id'], $data['data']['action']['assignee_id'], $todaydate, 'date_time', '1', "RA", "dealmanage", "new", null, $exactTime);
                            
                            }
                       
                        }

                        $processed=$c1."==".$cert;

                        // Set next action as TEST SUCCESSFULL
                        $this->setNextAction($text, $data['data']['action']['contact_id'], $data['data']['action']['assignee_id'], $todaydate, 'date_time', '1', "RA", "dealmanage", "new", null, $exactTime);

                    // $this->sendOrientationMail($contactdetails,$data);
                    
                    }else{
                        if($data['reason'] == "updated" || $data['reason'] == "completed") {
                            $checkaction = DB::Table("changelogs")
                                                ->where("entity_id",$data['data']['action']['id'])
                                                ->count();
                            if($checkaction > 0) {
                                $updatesms = DB::Table("changelogs")
                                                ->where("entity_id",$data['data']['action']['id'])
                                                ->update($action);
        
                               //  Log::info(' AT '.\Carbon\Carbon::now().' RESPONSE FROM UPDATE RECORD TO CHANGELOGS ('.$updatesms.')');
        
                            }else {
                                $setSms = DB::Table("changelogs")->insert($action);
                               // Log::info(' AT '.\Carbon\Carbon::now().' RESPONSE FROM NEW RECORD(UPDATE FAIL) TO CHANGELOGS ('.$setSms.')');
                            }
                                              
                        }
                        else {
                            $setSms = DB::Table("changelogs")->insert($action);
                             // Log::info(' AT '.\Carbon\Carbon::now().' RESPONSE FROM NEW RECORD TO CHANGELOGS ('.$setSms.')');
                        }
                    }
                    
                }

            //Test Data
            
            $mData = json_encode($data);

            $testD = [
                "Data"            =>$mData,
                "text"            =>$processed,
                "fname"            =>$fname,
                "type"            =>$data['type'],
                "data_time"  => \Carbon\Carbon::now()->toDateTimeString(),

            ];
            if($data['reason'] == "created") {

                $setData = DB::Table("test_table_listener")->insert($testD);
            }

        }

        }
        }else{
            

                        //Test Data
                        // $testD = [
                        //     "Data"            =>"EMPTY",
                        //     "text"            =>"DATA IS EMPTY",
                        // ];
                        // $setData = DB::Table("test_table_listener")->insert($testD);
        }

        
                     
        // dd("Hello world");
    }

    private function isJointAccount($checkJoint) {
        $result = false;
        if($checkJoint[0] == '*') {
            $result = true;
        }

        return $result;
    }

    private function getJointName($jointName) {
        $result = false;
        $jointName = explode("-", $jointName);
        if(sizeof($jointName) > 1) {
            $jointName = trim(ucwords(str_replace('*', '', $jointName[0])));
            $result    = $jointName;
        }
        return $result;
    }

    public function r_value($d,$id) {
        $result=1;
        foreach ($d->data->contact->custom_fields as $consultationkey => $consultationvalue) :
            if($consultationvalue->custom_field->id == $id) :
                 $result  = $consultationvalue->value;
            endif;
        endforeach;
        return $result;
    }

    
    // private function sendOrientationMail($contactdetails=NULL,$nData=NULL){

    //     if($contactdetails!=NULL && $nData!=NULL){
    
    //     $m_topUp=0;
    //     $code=0;
    
    //     $todaydate      = \Carbon\Carbon::now()->toDateString();
    //     $exactTime      = strtotime(\Carbon\Carbon::now()->addMinutes(15)->toDateTimeString());
    
    //     $contact_id=$contactdetails->data->contact->id;
    //     $url = Config::get('settings.ONEPAGE_URL')."deals?contact_id=".$contact_id;
    //     $ch  = curl_init( $url );
    //     curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET");
    //     curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    //     curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    //     curl_setopt( $ch, CURLOPT_USERPWD, Config::get('settings.ONEPAGE_USER').":".Config::get('settings.ONEPAGE_PASS'));
    //     curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
    
    //     $result = json_decode(curl_exec($ch));
    //     curl_close($ch);
        
    //     $p=$this->r_value($contactdetails,"5d69200f9b79b209cf3de505");
        
    //     $m_topUp=$this->r_value($contactdetails,"5d25b93f1787fac9aeb88ddd");
    //     if($p==1){
    
    //         $text="SEND ORIENTATION EMAIL FAIL-MISSING PRODUCT";
    //         $this->setNextAction($text, $nData['data']['action']['contact_id'], $nData['data']['action']['assignee_id'], $todaydate, 'date_time', '1', "RA", "dealmanage", "new", null, $exactTime);
    //     }else if($m_topUp==1){
    
    //         $text="SEND ORIENTATION EMAIL FAIL- MISSING TOP UP AMOUNT";
    //         $this->setNextAction($text, $nData['data']['action']['contact_id'], $nData['data']['action']['assignee_id'], $todaydate, 'date_time', '1', "RA", "dealmanage", "new", null, $exactTime);
            
    //     }else if(empty($result->data->deals)){
    
    //                 $text="SEND ORIENTATION EMAIL FAIL-MISSING DEAL";
    //                 $this->setNextAction($text, $nData['data']['action']['contact_id'], $nData['data']['action']['assignee_id'], $todaydate, 'date_time', '1', "RA", "dealmanage", "new", null, $exactTime);
    
    //             }else{
                
    //                 $c_fields=$contactdetails->data->contact->custom_fields;
    //                 $code=$this->r_value($contactdetails,"5d6d29b49b79b206a6453e76");
    //                 $am=$result->data->deals[0]->deal->amount;
    //                 $dt=$result->data->deals[0]->deal->expected_close_date;
    //                 $m=$contactdetails->data->contact->emails[0]->value;
    
    //                 $fname= $contactdetails->data->contact->first_name;
    //                 $last_name= $contactdetails->data->contact->last_name;
    //                 $data = $contactdetails->data->contact;
    //                 $product=$p;
    //                 $template    = 'mails.openaccount';
    //                 // $subject     = $user[0]->first_name.' '.$user[0]->last_name.' : '.strtoupper($product).' MEMBERSHIP ORIENTATION';
    //                 $subject     = strtoupper($product).' MEMBERSHIP ORIENTATION'. ' : '.$fname.' '.$last_name;
    //                 // $to          = $email;
    //                 $to          = $m;
    //                 $to_name     = $fname;
                
            
                        
    //                     $data = $contactdetails->data->contact;
                        
    //                     // $data->first_name="Peter";
    //                     // $data->last_name="Njoroge";
    //                     $data->amount=$am;
    //                     $data->start_date=$dt;
    //                     $data->month_topup=$m_topUp;
    //                     $data->product=$p;
    //                     $data->code=$code;
    //                     $associate = $this->getRep();
    
    //                     // $this->sendEmailService( $data, $template, $subject, $to, $to_name, $associate); 
                        
    //                         $from      = 'service@fourfrontmgt.ke'; 
    //                         $from_name = 'FourFront Service';
    
    //                     \Mail::send($template, ['user' => $data, 'associate' => $associate ], function ($message) use ($data, $subject, $from, $from_name, $to, $to_name, $associate) {
    //                         $message->from($from, $from_name)
    //                                 ->to($to, $to_name)
    //                                 ->cc($associate->email)
    //                                 ->bcc('4ferrors@gmail.com')
    //                                 ->bcc('5c78e2f31787fa44dd7b512d@users.onepagecrm.com')
    //                                 ->subject($subject);
    //                             }
    //                             );
    
    //                     // send email
    //                     // mail("venctor.pn@gmail.com" ,"My subject","This is a test");
    
    //                     $text="ORIENTATION EMAIL SENT SUCCESSFULLY";
    
    //                     $this->setNextAction($text, $nData['data']['action']['contact_id'], $nData['data']['action']['assignee_id'], $todaydate, 'date_time', '1', "RA", "dealmanage", "new", null, $exactTime);
    //             }
    //         }
    //     }
    

}