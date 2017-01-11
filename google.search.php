<?php
include_once 'lib/config.php';
/**
 * Created by PhpStorm.
 * User: Slight
 * Date: 2017/1/12
 * Time: 1:52
 */
class googleSearch
{
    public $code;
    public $msg;
    public $q;
    public $cx;
    public $data;
    public $num;
    public $start;


    public function __construct($q, $cx = "baidu", $start = 1, $num = 15)
    {
        $this->q     = $q;
        $this->num   = $num;
        $this->start = $start;
        switch ($cx){
            case 'baidu':
                $this->cx = baidu;
                break;
            case '360':
                $this->cx = _360;
                break;
        }
        $this->snoopy = new Snoopy();
        $this->init();
    }

    /**
     * @return int
     */
    public function init()
    {
        $snoopy = new Snoopy();
        $url = googleip . "q=$this->q&cx=$this->cx&key=". KEY ."&start=$this->start" . "&rsz=filtered_cse&hl=zh-CN&source=gsc&gss=.com&sig=04703ddcb4427915c6a790783dcfaed7&safe=off&filter=0&gl=203.208.46.180&qid=14872363177585f76&context=1&";
        $snoopy = $this->snoopy;
        $snoopy->fetch($url);
//        echo $url;
//        show($snoopy,1);
        if($snoopy->status != 200){
            return $this->setMsg(6);
        }
        $data = json_decode($snoopy->results,true);
        $this->data['queries']['nextPage'] = $data['queries']['nextPage'];
        $this->data['searchInformation'] = $data['searchInformation'];
        $this->data['items'] = $data['items'];
        $this->setMsg(0);
    }

    /**
     * @return mixed
     */
    public function getData()
    {

        $jsonArray = array(
            'code' => $this->code,
            'msg'  => $this->msg,
            'data' => $this->data
        );
        $jsonData = json_encode($jsonArray,JSON_UNESCAPED_UNICODE);
        return $jsonData;
    }


    protected function setMsg($retVal){
        $retValToMsg = array(
            0 => 'OK',
            1 => 'Wrong Password',
            2 => 'Timeout',
            3 => 'Network Outage',
            4 => 'Unknown Error',
            6 => 'error',
            65535 => 'Missing Parameters'
        );

        $this->msg  = $retValToMsg[$retVal];
        if($retVal == 6){
            $error = json_decode($this->snoopy->results,true);
            $retVal     = $this->snoopy->status;
            $this->msg  = $error['error']['message'];
        }
        $this->code = $retVal;
        return $this->code;
    }


}
$api = new googleSearch('java');
echo  $api->getData();