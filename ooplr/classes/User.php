<?php 

class User{
    private $isLoggedIn;
    private $_db,$_data,$_sessionName;
    public function __construct($user = null){
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        if (!$user){
            if(Session::exists( $this->_sessionName)){
                $user = Session::get( $this->_sessionName);
                if ($this->find($user)){
                    $this->isLoggedIn = true;
                }else{
                    // proccess Logout
                }
            }
        }else{
           $this->find($user); 
        }
    }
    public function create($fields= array()){
        if(!$this->_db->insert('users',$fields)){
            throw new Exception('DB error');
        }
    }
    public function find($username = null){
        if ($username){
            $field = (is_numeric($username)) ? 'id': 'username';
            $data = $this->_db->get('users', array($field,'=',$username));
            if($data->count()){
                $this->_data = $data->first();
                
                return true;
            }
        }
    }
    public function login($username = null,$password = null){
        //if ($username && $password){}
        $user = $this->find($username);
        if($user){
            if($this->data()->password === Hash::make($password,$this->data()->salt)){
                Session::put( $this->_sessionName,$this->data()->id);
                return true;
            }
        }
        return false;
    }
    public function data(){
        return $this->_data;
    }
    public function isLoggedIn(){
        return $this->isLoggedIn;
    }
    public function logOut(){
        Session::delete($this->_sessionName);
    }
}