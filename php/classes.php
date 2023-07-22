<?php
session_start();

class User
{
    // Properties
    public $id;
    public $username;
    public $fullname;
    public $address;
    public $password;
    public $email;

    function __construct($id, $username, $fullname, $address, $password, $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->fullname = $fullname;
        $this->address = $address;
        $this->password = $password;
        $this->email = $email;

    }

    // Methods

    // Id
    function set_id($id)
    {
        $this->id = $id;
    }
    public function get_id()
    {
        return $this->id;
    }

    // Username
    function set_username($username)
    {
        $this->username = $username;
    }
    public function get_username()
    {
        return $this->username;
    }

    // Fullname
    function set_fullname($fullname)
    {
        $this->fullname = $fullname;
    }
    public function get_fullname()
    {
        return $this->fullname;
    }

    // Address
    function set_address($address)
    {
        $this->address = $address;
    }
    public function get_address()
    {
        return $this->address;
    }

    // Password
    function set_password($password)
    {
        $this->password = $password;
    }
    public function get_password()
    {
        return $this->password;
    }

    // Email
    function set_email($email)
    {
        $this->email = $email;
    }
    public function get_email()
    {
        return $this->email;
    }
}


class Hotel
{
    // Properties
    public $id;
    public $name;
    public $pricePerNight;
    public $thumbnail;
    public $features;
    public $type;
    public $beds;
    public $rating;
    public $address;

    function __construct($id, $name, $pricePerNight, $thumbnail, $features, $type, $beds, $rating, $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->pricePerNight = $pricePerNight;
        $this->thumbnail = $thumbnail;
        $this->features = $features;
        $this->type = $type;
        $this->beds = $beds;
        $this->rating = $rating;
        $this->address = $address;

    }

    // Methods

    // Id
    function set_id($id)
    {
        $this->id = $id;
    }
    public function get_id()
    {
        return $this->id;
    }

    // Name
    function set_name($name)
    {
        $this->name = $name;
    }
    public function get_name()
    {
        return $this->name;
    }

    // Price Per Night
    function set_pricePerNight($pricePerNight)
    {
        $this->pricePerNight = $pricePerNight;
    }
    public function get_pricePerNight()
    {
        return $this->pricePerNight;
    }

    // Thumbnail
    function set_thumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }
    public function get_thumbnail()
    {
        return $this->thumbnail;
    }

    // Features
    function set_features($features)
    {
        $this->features = $features;
    }
    public function get_features()
    {
        return $this->features;
    }

    // Type
    function set_type($type)
    {
        $this->type = $type;
    }
    public function get_type()
    {
        return $this->type;
    }

    // Beds
    function set_beds($beds)
    {
        $this->beds = $beds;
    }
    public function get_beds()
    {
        return $this->beds;
    }

    // Rating
    function set_rating($rating)
    {
        $this->rating = $rating;
    }
    public function get_rating()
    {
        return $this->rating;
    }

    // Address
    function set_address($address)
    {
        $this->address = $address;
    }
    public function get_address()
    {
        return $this->address;
    }
}
?>