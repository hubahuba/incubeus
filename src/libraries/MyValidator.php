<?php namespace Ngungut\Nccms\Libraries;

use Illuminate\Validation\Validator;

class MyValidator extends Validator {

    private $_custom_messages = array(
        "slug" => "The :attribute may only contain letters, numbers, dashes and slash.",
    );

    public function __construct( $translator, $data, $rules, $messages = array(), $customAttributes = array() ) {
        parent::__construct( $translator, $data, $rules, $messages, $customAttributes );

        $this->_set_custom_stuff();
    }

    /**
     * Setup any customizations etc
     *
     * @return void
     */
    protected function _set_custom_stuff() {
        //setup our custom error messages
        $this->setCustomMessages( $this->_custom_messages );
    }

    /**
     * Allow only alphabets, spaces and dashes (hyphens and underscores)
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateSlug( $attribute, $value ) {
        return (bool) preg_match( "/^[A-Za-z0-9-_\/]+$/", $value );
    }

}