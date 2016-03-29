<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    /**
     * Copyright (c) 2001-2007 Simplewire. All rights reserved.
     * Simplewire, Inc. grants to Licensee, a non-exclusive, non-transferable,
     * royalty-free and limited license to use Licensed Software internally for
     * the purposes of evaluation only. No license is granted to Licensee
     * for any other purpose. Licensee may not sell, rent, loan or otherwise
     * encumber or transfer Licensed Software in whole or in part,
     * to any third party.

     * For more information on this license, please view the License.txt file
     * included with your download or visit www.simplewire.com
     */
    // check to make sure that CURL is loaded
    if (!extension_loaded('curl')) {
       trigger_error ("Simplewire SMS library requires CURL extension to be loaded", E_USER_ERROR);
    }

    // check to make sure that XML is loaded
    if (!extension_loaded('xml')) {
       trigger_error ("Simplewire SMS library requires XML Parser extension to be loaded", E_USER_ERROR);
    }

    //Using define to define constants to be used
    //PHP 5.0 version will include these in the class definition

    /**
     * Major version of the PHP SDK
     *
     * @global string SMS_VERSION_MAJ
     */
    define("SMS_VERSION_MAJ" , "4");

    /**
     * Minor version of the PHP SDK
     *
     * @global string SMS_VERSION_MIN
     */
    define("SMS_VERSION_MIN" , "2");

    /**
     * Revision number of the PHP SDK
     *
     * @global string SMS_VERSION_REV
     */
    define("SMS_VERSION_REV" , "0");

    /*
     * SMS Operations
     */

    /**
     * Internally used, declared as private to avoid creating documentation for it
     *
     * @access private
     * @global int SMS_OP_NONE
     */
    define("SMS_OP_NONE", 0);
    /**
     * Internally used, declared as private to avoid creating documentation for it
     *
     * @access private
     * @global int SMS_OP_SUBMIT
     */
    define("SMS_OP_SUBMIT", 1);
    /**
     * Internally used, declared as private to avoid creating documentation for it
     *
     * @access private
     * @global int SMS_OP_QUERY
     */
    define("SMS_OP_QUERY", 2);
    /**
     * Internally used, declared as private to avoid creating documentation for it
     *
     * @access private
     * @global int SMS_OP_DELIVER
     */
    define("SMS_OP_DELIVER", 3);
    /**
     * Internally used, declared as private to avoid creating documentation for it
     *
     * @access private
     * @global int SMS_OP_NOTIFY
     */
    define("SMS_OP_NOTIFY", 4);   // not supported yet

    //beginning of the documentation template
    /**#@+
      * @see Address::getType()
      * @see Address::setType()
      */

    /**
    * Represents an address type that is not known.
    *
    * An unknown address type should be used when the type of number cannot
    * be known beforehand.  In this case, Simplewire will make a best effort guess
    * at what the address means. An example of this address type is +17345551212.
    * The format is a '+' (plus character) followed by the country code, followed
    * by the national number. An unknown address is the default setting for all
    * addresses.  The INTERNATIONAL address type is recommended for all users,
    * unless there are explicit reasons why you need to use the other types.
    *
    * @global int SMS_ADDR_TYPE_UNKNOWN
    */

    define("SMS_ADDR_TYPE_UNKNOWN", 0);

    /**
    * Represents an address type for international numbers.
    *
    * An international address type is the most common and should be used when
    * using a true phone number. An example of this address type
    * is 17345551212. The format includes the country code followed by the national
    * number.  Please note that the major difference between UNKNOWN and INTERNATIONAL
    * address types is that INTERNATIONAL does not allow a '+' character before the
    * number and it also requires the country code, whereas this can sometimes be
    * omitted when using the UNKNOWN address type.
    *
    * @global int SMS_ADDR_TYPE_INTERNATIONAL
    */

  define("SMS_ADDR_TYPE_INTERNATIONAL", 1);

  /**
   * Represents an address type for network numbers also known as short codes.
   *
   * A network address type should be used when using "short codes".  Short codes
   * are phone numbers that are network-specific.  In other words, short codes are
   * typically activated only on a specific operator/carrier.  These phone numbers
   * are shorter in length than real phone numbers and they usually range from
   * being 3-6 digits in length. An example of this address type is 1209 or 30118.
   * Please note that "short codes" are activated on a case-by-case basis and not
   * all customer accounts will be allowed to use them.
   *
   * @global int SMS_ADDR_TYPE_NETWORK
   */

  define("SMS_ADDR_TYPE_NETWORK", 3);

    /**
    * Represents an address type that contains both digits and letters.
    *
    * An alphanumeric address should be used when trying to make the phone
    * display a string of text as a sender versus a numeric phone number.
    * An example of this address type is "Simplewire" instead of +17345551212.
    * Please note that your account may not be allowed to user alphanumeric
    * addresses and not all operators/carriers support them.  Typically, if
    * an operator does not support them, your source address request will be
    * ignored by Simplewire.
    *
    * @global int SMS_ADDR_TYPE_ALPHANUMERIC
    */

    define("SMS_ADDR_TYPE_ALPHANUMERIC", 5);

    /**#@-*/
    //End of templated documentation section for Address types


    /**
     * Version 2.0 of the Simplewire Wireless Message Protocol.
     *
     * @global int SMS_PROTOCOL_VERSION_2_0
     * @see SMS::getProtocolVersion()
     * @see SMS::setProtocolVersion()
     */
    define("SMS_PROTOCOL_VERSION_2_0" , 0x20);

    /**
     * Version 3.0 of the Simplewire Wireless Message Protocol.
     *
     * @global int SMS_PROTOCOL_VERSION_2_0
     * @see SMS::getProtocolVersion()
     * @see SMS::setProtocolVersion()
     */
    define("SMS_PROTOCOL_VERSION_3_0" , 0x30);


    /*
     *  Proxy Types
     */

    /**
     * No proxy server is used.  All other proxy properties will be ignored, this is the default value.
	   *
	   * @global int SMS_PROXY_TYPE_NONE
	   * @see SMS::setProxyServer()
     * @see SMS::setProxyPort()
     * @see SMS::setProxyUsername()
     * @see SMS::setProxyPassword()
	   */
    define("SMS_PROXY_TYPE_NONE", 0);

    /**
     * An HTTP/HTTPS proxy/firewall server will be used.  Please note that only Basic HTTP Authentication is supported in this version.
     *
     * @global int SMS_PROXY_TYPE_NONE
     * @see SMS::setProxyServer()
     * @see SMS::setProxyPort()
     * @see SMS::setProxyUsername()
     * @see SMS::setProxyPassword()
     */
   	define("SMS_PROXY_TYPE_HTTP", 1);

  	/**
  	 * A SOCKS version 4 proxy/firewall server will be used.
	   *
	   * @global int SMS_PROXY_TYPE_NONE
  	 * @see SMS::setProxyServer()
     * @see SMS::setProxyPort()
     * @see SMS::setProxyUsername()
     * @see SMS::setProxyPassword()
  	 */
    define("SMS_PROXY_TYPE_SOCKS4" , 2);

  	/**
  	 * A SOCKS version 5 proxy/firewall server will be used.
	   *
	   * @global int SMS_PROXY_TYPE_NONE
  	 * @see SMS::setProxyServer()
     * @see SMS::setProxyPort()
     * @see SMS::setProxyUsername()
     * @see SMS::setProxyPassword()
  	 */
    define("SMS_PROXY_TYPE_SOCKS5" , 3);


    /**
     * The type of network that the message is going to be sent or received from is none of the standard networks.
     *
     * @global int SMS_NETWORK_TYPE_NONE
     */
    define("SMS_NETWORK_TYPE_NONE" , 0);

    /**
     * The type of network that the message is going to be sent or received from is GSM.
     *
     * @global int SMS_NETWORK_TYPE_GSM
     */
    define("SMS_NETWORK_TYPE_GSM" , 1);

    /**
     * The type of network that the message is going to be sent or received from is TDMA.
     *
     * @global int SMS_NETWORK_TYPE_TDMA
     */
    define("SMS_NETWORK_TYPE_TDMA" , 2);

    /**
     * The type of network that the message is going to be sent or received from is CDMA.
     *
     * @global int SMS_NETWORK_TYPE_CDMA
     */
    define("SMS_NETWORK_TYPE_CDMA" , 3);

    /**
     * Determines the type of content that is being sent or received.  Data is used for standard messages.
     *
     * @global int SMS_CONTENT_DATA
     */
    define("SMS_CONTENT_DATA" , 0);

    /**
     * Determines the type of content that is being sent or received.  Content is used for special information like URLs
     *
     * @global int SMS_CONTENT_WAPPUSH
     */
    define("SMS_CONTENT_WAPPUSH" , 8);


  /**
   * This class is used to represent an address.
   *
   * The address is used to represent the different types of addresses that messages
   * can be sent to.  There are three fields that need to be set using the setters.
   * The fields can be retrieved using the getters
   *
   * @copyright Simplewire, Inc. 2001-2007
   * @version 4.2.0
   * @author Simplewire, Inc.
   */
  class Address {

        /**
         * Represents the type of address that is being used
         *
         * @access private
         */
        var $_type;

        /**
         * Represents the carrier of the address that is being used
         *
         * @access private
         */
        var $_carrier;

        /**
         * Represents the actual address of type $_type
         *
         * @access private
         */
        var $_address;

        /**
         * PHP 4 constructor, also works in PHP 5.
         */
        function Address ($address = NULL, $type = 0, $carrier = 0) {
          $this->_type = $type;  //Needs to be set to the constant ADDR_TYPE_UNKNOWN
          $this->_carrier = $carrier;
          $this->_address = $address;
        }


        /**
         * Sets the type of address
         *
         * The type of network (ton) attribute specifies what type-of-number the
         * network can expect to be used in the address attribute. Various types
         * of addresses can be used in the address attribute.
         *
         * @param integer $type The address type to be set.
         * @see SMS_ADDR_TYPE_UNKNOWN
         * @see SMS_ADDR_TYPE_INTERNATIONAL
         * @see SMS_ADDR_TYPE_NETWORK
         * @see SMS_ADDR_TYPE_ALPHANUMERIC
         * @return void
         */
        function setType($type)
        {
          $this->_type = $type;
        }


        /**
         * Sets the carrier id of address
         *
         * During a "deliver" operation, the carrier attribute specifies which
         * carrier id a message was sent from. This value will determine which
         * operator a mobile handset belongs to. Simplewire has assigned a
         * unique numeric code for each network operator. For example, T-Mobile
         * in the United States has a unique value of 79 in Simplewire's network.
         * Please refer to http://network.simplewire.com/ for a complete
         * real-time list of all carriers and their network identification
         * codes. Please note that Simplewire may or may not include this value
         * with a "deliver" request. The value may be set to 0 which should be
         * treated as if no carrier was included.
         * This attribute should not be used during a "submit" operation.
         *
         * @param int $carrier The carrier id to be set.
         * @return void
         */
        function setCarrier($carrier)
        {
          $this->_carrier = $carrier;
        }


        /**
         * Sets the address. For instance, the address of a mobile phone is the mobile number (there are other options as well).
         *
         * @param string $address The address to be set
         * @return void
         */
        function setAddress($address)
        {
          $this->_address = $address;
        }


        /**
         * Returns the type of address.
         *
         * @return integer The type of the address
         * @see SMS_ADDR_TYPE_UNKNOWN
         * @see SMS_ADDR_TYPE_INTERNATIONAL
         * @see SMS_ADDR_TYPE_NETWORK
         * @see SMS_ADDR_TYPE_ALPHANUMERIC
         * @see Address::setType()
         */
        function getType()
        {
          return $this->_type;
        }


        /**
         * Returns the carrier id of address.
         * @return integer The carrier id of address
         * @see Address::setCarrier()
         */
        function getCarrier()
        {
          return $this->_carrier;
        }


        /**
         * Returns the physical address
         *
         * @return string The physical address
         * @see Address::setAddress()
         */
        function getAddress()
        {
          return $this->_address;
        }


        /**
         * Converts Address into a String.
         *
         * Magic function in PHP 5, but will also work when manually called in PHP 4.
         * @return string The string representation of the entire address
         */
        function __toString() {
          return "(" . $this->getCarrier() . " " . $this->getType() . " " . $this->getAddress() . ")";
        }
	}

  /**
   * This class is used to represent as SMS message.
   *
   *
   *
   *
   *
   * @copyright Simplewire, Inc. 2001-2007
   * @version 4.2.0
   * @author Simplewire, Inc.
   */
  class SMS_MESSAGE {

    //Comment template that marks all member variables as private
    /**#@+
      @access private
      */

    var $m_IsSecure;              // defaults to false
    var $m_RemoteHost;            // defaults to wmp.simplewire.com
    var $m_RemotePort;            // defaults to 0

    var $m_UserAgent;             // defaults to PHP/SMS/{version}
    var $m_ProtocolVersion;       //Protocol used to send the message
    var $m_Version;               //Version of the SDK
    var $m_Text;                  //Actual text that is in the message
    var $m_Data;                  // alternative way of sending just data
    var $m_SourceAddr;            //Address of the sender
    var $m_DestinationAddr;       //Address of the destination
    var $m_AccountId;             //User ID for the SMS account
    var $m_AccountPassword;       //Users Password for the SMS account
    var $m_ChargeType;            //The type of the charge to issue for the message
    var $m_ChargeAmount;          //The amount of charge for the message to be sent
    var	$m_DestPort;			  //Destination port for SMS on handset
    var	$m_ProgramID;			  //ProgramID
    var $m_MessagePurpose;        //Optional for ads, Message Purpose Type
    var $m_AdRequirement;         //Optional for ads, requested or required
    var $m_AdviceOfChargeMessage; //Advice of charge message    

    var $m_TicketId;              // ticket of message

    var $m_ResponseXML;           //The response from the server after the XML is posted
    var $m_RequestXML;            //The formatted XML for the request to the server
    var $xmlParser;               //The parser that is used to parse the incoming XML

    var $m_Op;                    // Operation
    var $m_ResponseVersion;       //The version of the response XML from Simplewire
    var $m_ResponseProtocol;      //The protocol returned in the XML from Simplewire
    var $m_ResponseType;          //The type returned in the XML from Simplewire
    var $m_RequestVersion;
    var $m_RequestProtocol;
    var $m_RequestType;

    var $m_Debug;                 //Boolean used to print out extra information when in debug mode

    var $m_ErrorCode;             //Error code returned by simplewire
    var $m_ErrorDesc;             //Description of the error in the request
    var $m_ErrorResolution;       //Resolution of the error returned by Simplewire

    var $m_OptDataCoding;
    var $m_OptNetworkType;
    var $m_OptContentType;
    var $m_OptUrl;
    var $m_UdhIndicator;

    var $m_StatusCode;
    var $m_StatusDesc;

    var $m_CurlToSimplewire;      //Array used for converting between Curl Error codes and simplewire error codes

    /**#@-*/
    //End of the private variables template

    /**
     * Default constructor for the SMS class - Populates various fields with default values
     *
     *
     */

    function SMS_MESSAGE() {
        $this->m_IsSecure = false;
        //$this->m_RemoteHost = 'wmp.simplewire.com';
		$this->m_RemoteHost = 'smsc-01.openmarket.com/wmp';
        $this->m_RemotePort = 0;
        $this->m_Op = SMS_OP_NONE;

        // create the version string
        $this->m_Version = SMS_VERSION_MAJ . "." . SMS_VERSION_MIN . "." . SMS_VERSION_REV;
        $this->m_UserAgent = 'PHP/SMS/' . $this->m_Version . ' (' . PHP_OS . ')';
        $this->m_AccountId = NULL;
        $this->m_AccountPassword = NULL;
        $this->m_Text = NULL;
        $this->m_ChargeType = -1;
        $this->m_ChargeAmount = -1;
        $this->m_DestPort = -1;
        $this->m_ProgramID = NULL;        
        $this->m_MessagePurpose = NULL;
        $this->m_AdRequirement = NULL;
        $this->m_AdviceOfChargeMessage = NULL;        
        $this->m_SourceAddr = NULL;
        $this->m_DestinationAddr = NULL;
        $this->setProtocolVersion(SMS_PROTOCOL_VERSION_3_0);
        $this->m_UdhIndicator = false;
        $this->m_OptDataCoding = NULL;
        $this->m_OptNetworkType = SMS_NETWORK_TYPE_NONE;
        $this->m_OptContentType = SMS_CONTENT_DATA;
        $this->m_OptUrl = NULL;

        //Create the mapping of the CURL error code to the simplewire error codes
        //The array is a two dimensional array, the first dimension being the Curl
        //error code and the second dimension is the simplewire conversion and the
        //description of the error code
        $this->m_CurlToSimplewire = array(
          -1 => 101,    //Cannot find a curl error code that translates to simplewire error code
          -2 => 102,    //Cannot find a curl error code that translates to simplewire error code
          -3 => 103,    //Cannot find a curl error code that translates to simplewire error code
          -4 => 104,    //Cannot find a curl error code that translates to simplewire error code
          -5 => 105,    //Cannot find a curl error code that translates to simplewire error code
          CURLE_COULDNT_CONNECT => array( 106, "A connection could not be established with the Simplewire network."),
          CURLE_OPERATION_TIMEOUTED  => array( 107, "Internet The connection timed out."),
          CURLE_FAILED_INIT => array( 108, "Internet An internal error occured while connecting."),
          CURLE_URL_MALFORMAT => array( 109, "Internet Trying to use an invalid URL."),
          CURLE_COULDNT_RESOLVE_HOST  => array( 110, "Internet The host name could not be resolved."),
          CURLE_UNSUPPORTED_PROTOCOL  => array( 111, "Internet The specified protocol is not supported."),
          -6 => 112,    //Cannot find a curl error code that translates to simplewire error code
          -7 => 113,    //Cannot find a curl error code that translates to simplewire error code
          -8 => 114,    //Cannot find a curl error code that translates to simplewire error code
          -9 => 115,    //Cannot find a curl error code that translates to simplewire error code
          -10 => 116,   //Cannot find a curl error code that translates to simplewire error code
          -11 => 117,   //Cannot find a curl error code that translates to simplewire error code
          -12 => 118,   //Cannot find a curl error code that translates to simplewire error code
          -13 => 119,   //Cannot find a curl error code that translates to simplewire error code
          -14 => 120,   //Cannot find a curl error code that translates to simplewire error code
          -15 => 121,   //Cannot find a curl error code that translates to simplewire error code
          -16 => 122,   //Cannot find a curl error code that translates to simplewire error code
          CURLE_SEND_ERROR  => array( 123, "Internet An error occured while transfering data.")
          //Look at CURLE_HTTP_RETURNED_ERROR for more info on HTTP errors that are >= 400
          );
    }

    /**
     * Perform error on the CURL operations and set the error value
     * returns true if no error occurred, otherwise returns false
     *
     * @access private
     */
    function _curlErrorCheck($errorCode, $ch){
	  $errorCodeIndex = 0;
      $errorDescIndex = 1;
      if ($errorCode == 0){
        return true;
      }
      else {
        //Check to see if the curl error code translates to simplewire error code
        if(array_key_exists($errorCode, $this->m_CurlToSimplewire)){
          $this->m_ErrorCode = $this->m_CurlToSimplewire[$errorCode][$errorCodeIndex];
          //Should this be the simplewire code description or the curl code description????
          //$this->m_ErrorDesc = $this->m_CurlToSimplewire[$errorCode][$errorDescIndex];
          echo "Curl Error Description = " . curl_error($ch) . "</br>";
          $this->m_ErrorDesc = curl_error($ch);
        }
        else{
          $this->m_ErrorCode = 91;
          $this->m_ErrorDesc = curl_error($ch);
        }
      }
    }


    /**
     * Encode text params in xml into correct format
     * & ends up being &amp;
     * < ends up being &lt;
     * newline character ends up being &#10;
     *
     * @access private
     */
    function _xmlEncodeText($text) {
        // convert these characters to escaped sequence
		$badwordchars=array(
                           '&',
                           '&amp;#',
                           '<',
                           '>',
                           chr(10),
                           chr(13),
                           chr(34),
                           chr(39)
                           );
        $fixedwordchars=array(
                           '&amp;',
                           '&#',
                           '&lt;',
                           '&gt;',
                           '&#10;',
                           '&#13;',
                           '&#34;',
                           '&#39;'
                           );
       return str_replace($badwordchars, $fixedwordchars, $text);
    }


    /**
     * Converts the object to its XML representation.
     *
     * @return string the xml representation of the SMS properties
     * @access private
     */
    function _toXML($op) {

      $this->m_RequestXML  = '<?xml version="1.0" ?>' . "\r\n";

      // request element
      $this->m_RequestXML .= '<request';
      $this->m_RequestXML .= ' version="' . $this->m_RequestVersion . '"';
      $this->m_RequestXML .= ' protocol="' . $this->m_RequestProtocol . '"';

    if ($op == SMS_OP_SUBMIT) {
        $this->m_RequestXML .= ' type="submit"';
    } else if ($op == SMS_OP_QUERY) {
        $this->m_RequestXML .= ' type="query"';
    }

      $this->m_RequestXML .= '>' . "\r\n";

      // user element
      $this->m_RequestXML .= '<user';
      $this->m_RequestXML .= ' agent="' . $this->m_UserAgent . '"';
      $this->m_RequestXML .= '/>' . "\r\n";

      // account element
      $this->m_RequestXML .= '<account';
      $this->m_RequestXML .= ' id="' . $this->m_AccountId . '"';
      $this->m_RequestXML .= ' password="' . $this->m_AccountPassword . '"';
      $this->m_RequestXML .= '/>' . "\r\n";

      if ($this->m_Op == SMS_OP_QUERY) {

         // check to see if source address element needed
          if (isset($this->m_TicketId)) {
            $this->m_RequestXML .= '<ticket';
            $this->m_RequestXML .= ' id="' . $this->m_TicketId . '"';
            $this->m_RequestXML .= '/>' . "\r\n";
          }

      } else if ($this->m_Op == SMS_OP_SUBMIT) {

          // check to see if source address element needed
          if (isset($this->m_SourceAddr)) {

            $this->m_RequestXML .= '<source';

            // check if the carrier attr should be included
            if ($this->m_SourceAddr->getCarrier() > 0) {
              $this->m_RequestXML .= ' carrier="' . $this->m_SourceAddr->getCarrier() . '"';
            }

            $this->m_RequestXML .= ' ton="' . $this->m_SourceAddr->getType() . '"';
            $this->m_RequestXML .= ' address="' . $this->m_SourceAddr->getAddress() . '"';
            $this->m_RequestXML .= '/>' . "\r\n";
          }

          // check to see if dest address element needed
          if (isset($this->m_DestinationAddr)) {

            $this->m_RequestXML .= '<destination';

            // check if the carrier attr should be included
            if ($this->m_DestinationAddr->getCarrier() > 0) {
              $this->m_RequestXML .= ' carrier="' . $this->m_DestinationAddr->getCarrier() . '"';
            }

            $this->m_RequestXML .= ' ton="' . $this->m_DestinationAddr->getType() . '"';
            $this->m_RequestXML .= ' address="' . $this->m_DestinationAddr->getAddress() . '"';
            $this->m_RequestXML .= '/>' . "\r\n";
          }

          // check to see if option element is even needed
          if (  $this->m_ChargeType >= 0 ||
                $this->m_ChargeAmount >= 0 ||
                $this->m_DestPort >= 0 ||
                isset($this->m_ProgramID) ||                
                isset($this->m_MessagePurpose) ||
                isset($this->m_AdviceOfChargeMessage) ||                
                isset($this->m_OptDataCoding) ||
                $this->m_OptNetworkType > 0 ||
                isset($this->m_OptUrl) ||
                $this->m_OptContentType > 0) {
            // add optional paramters
            $this->m_RequestXML .= '<option';

            // add charge type?
            if ($this->m_ChargeType >= 0) {
                $this->m_RequestXML .= ' charge_type="' . $this->m_ChargeType . '"';
            }

            // add charge amount?
            if ($this->m_ChargeAmount >= 0) {
                $this->m_RequestXML .= ' charge_amount="' . $this->m_ChargeAmount . '"';
            }

            // add content type?
            if ($this->m_OptContentType > 0) {
                $this->m_RequestXML .= ' type="';
                if ($this->m_OptContentType == SMS_CONTENT_WAPPUSH) {
                    $this->m_RequestXML .= 'wap_push';
                }
                $this->m_RequestXML .= '"';
            }

			// add destination port?
			if ($this->m_DestPort >= 0) {
			    $this->m_RequestXML .= ' dest_port="' . $this->m_DestPort . '"';
            }

            // add network type?
            if ($this->m_OptNetworkType > 0) {
                $this->m_RequestXML .= ' network_type="';
                if ($this->m_OptNetworkType == SMS_NETWORK_TYPE_GSM) {
                    $this->m_RequestXML .= 'GSM';
                } else if ($this->m_OptNetworkType == SMS_NETWORK_TYPE_TDMA) {
                    $this->m_RequestXML .= 'TDMA';
                } else if ($this->m_OptNetworkType == SMS_NETWORK_TYPE_CDMA) {
                    $this->m_RequestXML .= 'CDMA';
                }
				$this->m_RequestXML .= '"';
        	}

	        // add opt url?
        	if (isset($this->m_OptUrl)) {
            	$this->m_RequestXML .= ' url="' . $this->_xmlEncodeText($this->m_OptUrl) . '"';
        	}

        	// add Program ID?
			if (isset($this->m_ProgramID)) {
			   	$this->m_RequestXML .= ' program_id="' . $this->_xmlEncodeText($this->m_ProgramID) . '"';
        	}       

        	// add Message Purpose?
			if (isset($this->m_MessagePurpose)) {
			   	$this->m_RequestXML .= ' purpose="' . $this->_xmlEncodeText($this->m_MessagePurpose) . '"';
        	}
        	
         	// add Advice of Charge Message?
			if (isset($this->m_AdviceOfChargeMessage)) {
			   	$this->m_RequestXML .= ' advice_of_charge_message="' . $this->_xmlEncodeText($this->m_AdviceOfChargeMessage) . '"';
        	}

	        $this->m_RequestXML .= '/>' . "\r\n";
      }

      $this->m_RequestXML .= '<message';
      $this->m_RequestXML .= ' text="' . $this->_xmlEncodeText($this->m_Text) . '"';
      
      // add Ad Requirement?
	  if (isset($this->m_AdRequirement)) {
	      $this->m_RequestXML .= ' ad="' . $this->_xmlEncodeText($this->m_AdRequirement) . '"';
      }        	      
      
      $this->m_RequestXML .= '/>' . "\r\n";

      }

      // finish xml
      $this->m_RequestXML .= '</request>';

      return $this->m_RequestXML;
    }

    /**
     * Returns whether or not the last request was a success.
     *
     * @return bool Represents whether the last request was a success
     * @access private
     */
    function isSuccess() {
      if (isset($this->m_ErrorCode) && $this->m_ErrorCode >= 0 && $this->m_ErrorCode <= 10) {
        return true;
      }
      return false;
    }

    /**
     * Submits message for delivery.
     *
     * This operation is used to submit Mobile Terminated/Outbound SMS for
     * delivery to a mobile handset. It is a client-to-server request. Both text
     * and binary content are supported, as well as various enhanced message
     * types such as WAP push, J2ME midlet push, and more.

     * Please note that a submit request only queues a message for delivery on
     * the network.  A successful submit response only means that the message
     * passed all error checking and was placed in a queue for delivery. In
     * order to find out if that message was delivered to a handset, your client
     * application will need to save the ticket id that is returned after a
     * successful submit operation.  This ticket id will be later used in a query
     * operation to track the delivery status of that message.

     *
     * @return bool Represents whether the submit was a success or not
     */
    function submit() {
        // set operation type and send request
        $this->_send(SMS_OP_SUBMIT);
        return $this->isSuccess();
    }

    /**
     * Queries message delivery status.
     *
     * @return bool Represents the status of the delivery
     */
    function query() {
        // set operation type and send request
        $this->_send(SMS_OP_QUERY);
        return $this->isSuccess();
    }

    /**
     * Sends off the request by posting the content to the correct servers. This
     * function handles all the necessary connection calculations and timeouts.
     * It will store a string of the content returned from Simplewire.
     *
     * @return void
     * @access private
    */
    function _send($op) {

        $this->m_Op = $op;

        // create the XML string that gets posted to the server
        $this->_toXML($op);

      if ($this->m_Debug) {
        echo htmlEntities($this->m_RequestXML) . "</br></br>";
      }

      //Send the string to the server
      //opens the connections and sends the xml
      $content_len = strlen($this->m_RequestXML);
      $path = "/wmp";

      //If instead of http:// you give asdda://, then the curl Error code is CURLE_UNSUPPORTED_PROTOCOL
      //If you give http:, the protocol is correct, but this results in CURLE_OPERATION_TIMEOUTED
      //If you give http:/, this results in CURLE_COULDNT_RESOLVE_HOST
      //If you give a bad port number, the curl error code return is CURLE_COULDNT_CONNECT
      //If you give an invalid IP address, the curl error code returned is CURLE_COULDNT_CONNECT

      // create url we'll post to
      if ($this->m_IsSecure) {
        $url = 'https://';
      } else {
        $url = 'http://';
      }

      $url .= $this->m_RemoteHost;
		
      if ($this->m_RemotePort > 0) {
        $url .= ':' . $this->m_RemotePort;
      }

      $url .= '/wmp';

      if ($this->m_Debug) {
          echo "POST URL: " . $url . "</br>"; 
      }

      // set content type to xml
      $headers = array("Content-Type: text/xml",);
      $ch = curl_init();
      // check if it was initialized okay
      $rv = curl_errno($ch);
      //Temporary debugging
      if($this->m_Debug){
        print("Curl Error Code After Initialization = " . $rv . "</br>");
      }

      // error check on curl
      if (!($this->_curlErrorCheck($rv, $ch))) {
        return false;
      }

      // set curl options
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $this->m_RequestXML);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //returns to data var, not as output

      //TODO:
      //Curl options for proxys
      //if($this->m_ProxyServer){
      //  if($this->m_ProxyType == SMS_PROXY_TYPE_HTTP){
      //  }
      //}

      // send request, recv response
      $this->m_ResponseXML = curl_exec($ch);
      $rv = curl_errno($ch);

      //Temporary debugging
      if($this->m_Debug){
        print("Curl Error Code After Posting = " . $rv . "</br>");
      }

      // error check return value of the curl exec
      if (!($this->_curlErrorCheck($rv, $ch))) {
        curl_close ($ch);
        return false;
      }
      curl_close ($ch);

      // parse the response from the server
      if ($this->m_Debug) {
          print("response:<br>");
          echo htmlEntities($this->m_ResponseXML) . "</br></br>";
      }
      $this->parse($this->m_ResponseXML);
	 }

  /***********
   * Getters *
   ***********/

  /**
   * Returns whether or not the message has been delivered
   *
   * @return bool Whether or not the message has been delivered
   */
  function isDeliver() {
    return ($this->m_Op == SMS_OP_DELIVER);
  }

  /**
   * Returns whether or not the connection is secure
   *
   * @return bool Whether or not the connection is secure
   */
  function isSecure() {
    return $this->m_IsSecure;
  }

  /**
   * Returns the protocol of the message that is sent or received, either SMS_PROTOCOL_VERSION_2_0 or SMS_PROTOCOL_VERSION_3_0
   *
   * @return int The integer that represents the protocol of the message being sent
   * @see SMS_PROTOCOL_VERSION_2_0
   * @see SMS_PROTOCOL_VERSION_3_0
   * @see SMS::setProtocolVersion()
   */
  function getProtocolVersion() {
    return $this->m_ProtocolVersion;
  }

  /**
   * The web address that the message is being sent to for delivery, defaults to wmp.simplewire.com
   *
   * @return string The web address that the message is being sent to
   * @see SMS::setRemoteHost()
   */
  function getRemoteHost() {
    return $this->m_RemoteHost;
  }

  /**
   * Returns the port number that is trying to be connected to at the wmp server, default is 0
   *
   * @return int The port number of the wmp server that you are trying to connect to
   * @see setRemotePort()
   */
  function getRemotePort() {
    return $this->m_RemotePort;
  }

  /**
   * Returns the error code that has been set by either sending the message to the wmp server or the response from the wmp server
   *
   * @return int The error that has been encountered, 2 for success
   * @see SMS::getErrorDescription()
   * @see SMS::getErrorResolution()
   */
  function getErrorCode() {
    return $this->m_ErrorCode;
  }

  /**
   * Returns a description of the error that has been encountered
   *
   * @return string A description of the error that has been encountered
   * @see SMS::getErrorCode()
   * @see SMS::getErrorResolution()
   */
  function getErrorDescription() {
    return $this->m_ErrorDesc;
  }

  /**
   * Returns how to fix the error that has been encountered
   *
   * @return string Description of how to fix the error
   * @see SMS::getErrorCode()
   * @see SMS::getErrorDescription()
   */
  function getErrorResolution() {
    return $this->m_ErrorResolution;
  }

  /**
   * Returns a string that contains information about the SDK and machine that are being used
   *
   * The format of the string is "ProgrammingLanguage/SMS/Version (OperatingSystem)"
   *
   * @return string Information about the SDK and machine that are being used
   */
  function getUserAgent() {
    return $this->m_UserAgent;
  }

  /**
   * Returns the version of the SDK being used for development
   *
   * @return string Version of the SDK
   */
  function getVersion() {
    return $this->m_Version;
  }

  /**
   * Returns the Simplewire Account ID that is being used
   *
   * @return string The Simplewire account ID
   * @see SMS::setAccountId()
   */
  function getAccountId(){
    return $this->m_AccountId;
  }

  /**
   * Returns the Simplewire Account password that is being used
   *
   * @return string The Simplewire account password
   * @see SMS::setAccountPassword()
   */
  function getAccountPassword() {
    return $this->m_AccountPassword;
  }

  /**
   * Returns the text of the SMS message.
   *
   * If multi-byte characters are sent in the data field, the text is a best guess
   * of the textual information that is contained in the data.
   *
   * @return string The text of the SMS message
   * @see SMS::setMessageText()
   */
  function getMessageText() {
    return $this->m_Text;
  }

  /**
   * Returns the data that is in the message
   *
   * The first two bytes of the data indicate how large the header is.  The rest of the
   * data is found after the header
   *
   * @return string The data in the message
   * @see SMS::setMessageData()
   */
  function getMessageData() {
    return $this->m_Data;
  }

  /**
   * Returns the address object of the source address
   *
   * @return Address returns the object that contains the source address
   * @see SMS::setSourceAddr()
   */
  function getSourceAddr() {
    return $this->m_SourceAddr;
  }

  /**
   * Returns the address object of the destination address
   *
   * @return Address Returns the object that contains the source address
   * @see SMS::setDestinationAddr()
   */
  function getDestinationAddr() {
    return $this->m_DestinationAddr;
  }

  /**
   * Returns the ticket ID of the message.  This is a unique alpha numeric string that can be used for tracking messages
   *
   * The ticket id is a unique reference string that can be used to track the delivery status of the message. The ticket id is usually a maximum of 23 characters in length. This attribute is normally only returned after a successful "submit" request operation. This value should be saved by the client so that it can be later used during a "query" request operation.
   *
   * @return string Returns the ticket ID of the message
   */
  function getTicketId() {
    return $this->m_TicketId;
  }

  /**
   * Returns the status code that is received from the response from simplewire.
   *
   * This element contains the status code of a previously submitted message. The status code can be used to track the delivery status of a message. During the lifetime of a message, a message's delivery state may change several times. The most common status codes are:
   *
   * 0 => Message successfully sent to carrier.
   *
   * 2 => Message successfully queued.
   *
   * 3 => Message buffered with carrier and waiting delivery.
   *
   * 4 => Message successfully delivered.
   *
   * 5 => Message transferred to carrier and waiting delivery.
   *
   * 810 => Message delivery failed.
   *
   * There are many other status codes, please see the error and status code appendix at the end of this document
   *
   * @return int The status code recieved from Simplewire
   * @see SMS::getStatusDescription()
   */
  function getStatusCode() {
    return $this->m_StatusCode;
  }

  /**
   * Returns a textual description of the status code that is received from Simplewire
   *
   * @return string Textual description of the status code
   */
  function getStatusDescription() {
    return $this->m_StatusDesc;
  }

  /**
   * Returns whether or not debug mode is turned on.  If debug mode is turned on, extra information is print out to the screen
   *
   * @return bool Whether or not debug mode is turned on
   * @see SMS::setDebugMode()
   */
  function getDebugMode() {
    if($this->m_Debug){
      return 1;
    } else{
      return 0;
    }
  }

  /**
   * Returns the optional data encoding.  For instance it can be "uc2" for a unicode string
   *
   * @return string The data encoding that is used
   */
  function getOptDataCoding(){
    return $this->m_OptDataCoding;
  }

  /**
   * Get the optional URL to be used
   *
   * @return string The string that is the Opt URL
   * @see SMS::setOptUrl()
   */
  function getOptUrl() {
    return $this->m_OptUrl;
  }

  /**
   * Get the type of network that is going to be used to send the message
   *
   * @return int One of the constants listed above
   * @see SMS::setOptNetworkType()
   * @see SMS_NETWORK_TYPE_NONE
   * @see SMS_NETWORK_TYPE_GSM
   * @see SMS_NETWORK_TYPE_TDMA
   * @see SMS_NETWORK_TYPE_CDMA
   */
  function getOptNetworkType() {
    return $this->m_OptNetworkType;
  }

  /**
   * Get the type of content that is going to be dealt with
   *
   * @return int One of the constants listed above
   * @see SMS::setContentType()
   * @see SMS_CONTENT_DATA
   * @see SMS_CONTENT_WAPPUSH
   */
  function getContentType() {
    return $this->m_OptContentType;
  }

  /**
   * Get the charge type that is used for premium messages
   *
   * @return int The type of charge that is being applied
   * @see SMS::setChargeType()
   */
  function getChargeType(){
    return $this->m_ChargeType;
  }

  /**
   * Get the charge amount that is used for premium messages, in dollars
   *
   * @return double The amount that is being charged for the message in dollars
   * @see SMS::setChargeAmount()
   */
  function getChargeAmount(){
    return $this->m_ChargeAmount;
  }

  /**
   * Get the destination port that the SMS is sent to
   *
   * @return double The port number for the SMS
   * @see SMS::setDestPort()
   */
  function getDestPort(){
    return $this->m_DestPort;
  }

  /**
   * Get the destination port that the SMS is sent to
   *
   * @return double The port number for the SMS
   * @see SMS::setDestPort()
   */
  function getProgramID(){
    return $this->m_ProgramID;
  }  

  /**
   * SMS Advertising uses this field to determine if sending an ad with the type of 
   * content is allowed in business rules.  Ads are only allowed for "standard_content" 
   * purpose messages.
   *
   * @return The message purpose
   * @see SMS::setMessagePurpose()
   */
  function getMessagePurpose(){
    return $this->m_MessagePurpose;
  } 

  /**
   * This is used for SMS Advertising
   *
   * @return The ad requirement
   * @see SMS::setAdRequirement()
   */
  function getAdRequirement(){
    return $this->m_AdRequirement;
  } 

  /**
   * Get the optional Advice Of Charge Message
   *
   * @return The advice of charge message
   * @see SMS::setAdviceOfChargeMessage()
   */
  function getAdviceOfChargeMessage(){
    return $this->m_AdviceOfChargeMessage;
  }

  /***********
   * Setters *
   ***********/

  /**
   * Set the type of network that is going to be used to send the message
   *
   * @param integer $networkType One of the constants listed above
   * @return void
   * @see SMS::getOptNetworkType()
   * @see SMS_NETWORK_TYPE_NONE
   * @see SMS_NETWORK_TYPE_GSM
   * @see SMS_NETWORK_TYPE_TDMA
   * @see SMS_NETWORK_TYPE_CDMA
   */
  function setOptNetworkType($networkType) {
    // error check
    if ($networkType < 0 || $networkType > 3) {
      trigger_error ("setNetworkType only accepts values between 0-3, see constants", E_USER_ERROR);
    }
    $this->m_OptNetworkType = intval($networkType);
  }

  /**
   * Set the type of content that is going to be dealt with
   *
   *The type attribute will modify what type of message may be contained in the request. For example, during a submit request, the client may wish to send a WAP Push message instead of a normal text or binary message. In this case, the type attribute would be set to WAP_PUSH. The type attribute should be used when the content type of the message should be changed from the default.

   *
   * NOTE: Any type of content can always be manually encoded by the client and sent as a normal binary message. Content types such as WAP_PUSH are only meant to simplify client applications.

   *
   * @param integer $contentType One of the constants listed above
   * @return void
   * @see SMS::getContentType()
   * @see SMS_CONTENT_DATA
   * @see SMS_CONTENT_WAPPUSH
   */
  function setContentType($contentType) {
    // error check
    if ($contentType < 0 || $contentType > 8) {
      trigger_error ("setContentType only accepts values between 0-8, see constants", E_USER_ERROR);
    }
    $this->m_OptContentType = intval($contentType);
  }

  /**
   * Set the optional URL to be used
   *
   * The url attribute will specify what URL (Uniform Resource Locator) a phone should be directed to when a WAP_PUSH type of submit is requested. If the type is not set to WAP_PUSH, then this attribute will be ignored. The proper format is a comlete URL including the leading http:// or https://.
   *
   * @param string $url String that represents the new URL
   * @return void
   * @see SMS::getOptUrl()
   */
  function setOptUrl($url) {
    $this->m_OptUrl = $url;
  }

  /**
   * Set the ticket ID to be used for the message.
   *
   * @param string $ticketID String that represents the new ticket ID
   * @return void
   * @see SMS::getTicketID()
   */
  function setTicketId($ticketId){
    $this->m_TicketId = (string)$ticketId;
  }

  /**
   * Set the charge type that is used for premium messages
   *
   * This attribute should ONLY be used if your know your account has been setup for premium SMS. The charge_type attribute controls whether an SMS should trigger a charge to be placed on the recipient's mobile phone bill. If this property is omitted from the submit request, Simplewire will default its value to the account's pre-configured setting. Please note that while this typically defaults to 0 (non-premium), it is possible that the default is 1 (premium). A charge_type may be set to the following values:
   *
   * 0 = do not charge (non-premium SMS)
   * 1 = charge recipient (premium SMS)
   *
   * @param int $chargeType Int that represents the new charge type
   * @return void
   * @see SMS::getChargeType()
   */
  function setChargeType($chargeType){
    $this->m_ChargeType = intval($chargeType);
  }

  /**
   * Set the charge amount that is used for premium messages, in dollars
   *
   * This attribute should ONLY be used if your know your account has been setup for premium SMS. The charge_amount optional property controls which price tier will be used for the charge on the recipient's mobile phone bill. This optional property is only valid when all the following apply:
   *
   * The charge_type property is set to 1
   *
   * The charge_amount is pre-approved by Simplewire.
   *
   * The charge_amount is an integer representation of the total number cents, pence, etc. to charge for the premium SMS. The currency of the amount is always considered local to the country of the destination address. For example, if the destination is a US recipient, the charge_amount will be interpreted as US dollars. On the other hand, if the destination address is within Australia, then the amount will be interpreted as Australian dollars.
In the United States, for a $1.99 charge, this value would be set to 199. In other countries such as the United Kingdom, for a ï¿½0.25 charge, this value would be set to 25.
A charge_amount may be set to an integer value representing the amount to charge.
   *
   * $1.99 charge should be 199 for this value.
   *
   * $0.30 charge should be 30 for this value.
   *
   * $1.50 charge should be 150 for this value.
   *
   * ï¿½0.25 charge should be 25 for this value.
   *
   * @param double $chargeAmount double that represents the amount to charge
   * @return void
   * @see SMS::getChargeAmount()
   */
  function setChargeAmount($chargeAmount){
    $this->m_ChargeAmount = intval($chargeAmount);
  }

  /**
   * Set the destination port on the phone to sent the SMS to
   *
   * @param double $destport double that represents the port number
   * @return void
   * @see SMS::getDestPort()
   */
  function setDestPort($destPort){
    $this->m_DestPort = intval($destPort);
  }

  /**
   * Set the Program ID, used for subscription premium transactions
   *
   * @param string $programid string that represents the string
   * @return void
   * @see SMS::getProgramID()
   */
  function setProgramID($ProgramID){
    $this->m_ProgramID = $ProgramID;
  }
  
  /**
   * Set the Message Purpose.  Required if "ad" included in submit request; otherwise optional.
   *
   * Valid values:
   * "standard_content", "premium_content", "opt_in_premium", "opt_in_standard", 
   * "stop_confirmation", "help_response", "other_administrative".  
   *
   * If the value submitted is not in the specified set, reject the submit request.
   *
   * @param string $MessagePurpose string that represents the purpose
   * @return void
   * @see SMS::getMessagePurpose()
   */
  function setMessagePurpose($MessagePurpose){
    $this->m_MessagePurpose = $MessagePurpose;
  } 

  /**
   * Values: 'required', 'requested'.  If the value submitted is not in the specified set, 
   * reject the submit request. This is used for SMS Advertising.  If 'required' is 
   * specified and if an ad is not retreived, then the message will fail.  If the 
   * 'requested' is specified and if an ad is not retrieved, then WMP will proceed with 
   * sending the message without the ad. 
   *  
   * @param string $AdRequirement string that represents the ad requirement
   * @return void
   * @see SMS::getAdRequirement()
   */
  function setAdRequirement($AdRequirement){
    $this->m_AdRequirement = $AdRequirement;
  } 

  /**
   * Set the Advice of Charge Message. Optional. Maximum length: 50 characters.
   *
   * @param string $AdviceOfChargeMessage string that represents the opt_in message
   * @return void
   * @see SMS::getAdviceOfChargeMessage()
   */
  function setAdviceOfChargeMessage($AdviceOfChargeMessage){
    $this->m_AdviceOfChargeMessage = $AdviceOfChargeMessage;
  }

  /**
   * Set the security level to use, true for https:// and false for http://
   *
   * @param bool $secure Bool that tells which transport protocol to use
   * @return void
   * @see SMS::isSecure()
   */
  function setSecure($secure){
    $this->m_IsSecure = (bool)$secure;
  }

  /**
   * Set the remote host to submit messages to, defaults to wmp.simplewire.com
   *
   * @param string $host String that give the address of the new host to use
   * @return void
   * @see SMS::getRemoteHost()
   */
  function setRemoteHost($host){
    $this->m_RemoteHost = $host;
  }

  /**
   * Set the remote port to connect to on the remote host.  Defaults to port 0
   *
   *
   *
   * @param integer $port integer that represent the new remote host port to connect to
   * @return void
   * @see SMS::getRemotePort()
   */
  function setRemotePort($port){
    $this->m_RemotePort = $port;
  }

  /**
   * Set the Simplewire account ID
   *
   * This element is is used for specifying the Simplewire customer
   * authentication information.  This is required to be set by the user of the
   * SDK.  To obtain an account with Simplewire please contact your local
   * Simplewire Account Representative.
   *
   * The ID is also referred to as the SubscriberID.  The account ID is typically
   * 17 characters in lenght.
   *
   * @param string $id String that represents the user's Simplewire account ID
   * @return void
   * @see SMS::getAccountId()
   */
  function setAccountId($id){
    $this->m_AccountId = $id;
  }

  /**
   * Set the Simplewire account password
   *
   * The password attribute is the secret password for teh account ID
   *
   * @param string $password String that represents the user's Simplwire account password
   * @return void
   * @see SMS::getAccountPassword()
   */
  function setAccountPassword($password) {
    $this->m_AccountPassword = $password;
  }

  /**
   * Set the text to be sent for the message
   *
   * The text attribute is used when sending or receiving a text message.  Text is defined as normally printable characters such as an ASCII character, newline character, ampersand character, etc. The text attribute should NOT be used when sending arbitrary binary characters such as a byte value of 0x00. In those cases, the data attribute should be used. If you are unsure of the content you will send, or it may be a mixture of text or binary content, Simplewire recommends using the data attribute for every message.
   *
   * If using the text attribute, please note that some characters may have to be properly XML-escaped, otherwise, your request will error out and say "Invalid XML". For example, if you wanted to send an ampersand character (&) within the text attribute, you would need to escape this value to &amp;. Further, if one wanted to send a newline character in the text attribute, this value would need to be escaped to &#10;
   *
   * @param string $newText String that represents the new text to be set
   * @return void
   * @see SMS::getMessageText()
   */
  function setMessageText($newText) {
    $this->m_Text = $newText;
  }

  /**
   * Checks to make sure that an object of type Address is passed into this function and sets the destination address
   *
   * This element is for specifying the destination address of the message.  During a "submit" operation, the destination address is going to determine the recipient of the message. During a "deliver" operation, the destination address is going to specify which short code or long code the message was sent to.
   *
   * CARRIER:
   *
   * During a "submit" operation, the carrier attribute attempts to override which carrier a message will be sent to. Unless otherwise directed by Simplewire, Simplewire recommends not setting this property. The network will usually attempt to auto-recognize which carrier a message should be sent to. Simplewire has assigned a unique numeric code for each network operator. For example, T-Mobile in the United States has a unique value of 79 in Simplewire's network. Please refer to http://network.simplewire.com/ for a complete real-time list of all carriers and their network identification codes. Please note that Simplewire may or may not utilize this value during a "submit" operation. The network may also return an error back to the client if the account is not permitted to specify this parameter.
   *
   * TYPE OF NETWORK (ton):
   *
   * The ton attribute specifies what type-of-number the network can expect to be used in the address attribute. Various types of addresses can be used in the address attribute. Supported address types and their ton values include:
   *
   *Please see the destination address attribute for more information. If the ton is not included, its default value is 0.
   *
   * Based on the ton value, the address field may be interpreted differently. Acceptable formats based on the ton value are:
   *
   * SMS_ADDR_TYPE_UNKNOWN - An unknown address means that the type isn't known beforehand and a best guess is performed by the network. Usually, addresses of this type look like +13135551212 where the format is +<country code><national number>.
   *
   * SMS_ADDR_TYPE_INTERNATIONAL - An international address is a fully qualified phone number. Its similar to an unknown address, but its format is <country code><national number>.  Please note there is no leading + character.
   *
   * SMS_ADDR_TYPE_NETWORK - A short code address is usually between 4 and 6 digits in length. For example, 10900 or 1544 are short codes.
   *
   * @param Address $destAddr Address object that represents the new destination
   * @return int 0 if member variable is assigned, nonzero if there was a problem (incorrect type)
   * @see SMS::getDestinationAddr()
   * @see Address::setType()
   * @see Address::setAddress()
   * @see Address::setCarrier()
   * @see SMS_ADDR_TYPE_UNKNOWN
   * @see SMS_ADDR_TYPE_INTERNATIONAL
   * @see SMS_ADDR_TYPE_NETWORK
   */
  function setDestinationAddr($destAddr) {
    $type = strtolower(getType($destAddr));
    $class = strtolower(get_class($destAddr));

    // check if setting it to null
    if (!isset($destAddr))
    {
        $this->m_DestinationAddr = NULL;
    }
    else if ($type == "object" && $class == "address")
    {
      $this->m_DestinationAddr = $destAddr;
    }
    else
    {
      trigger_error ("setDestinationAddr requires Address object type", E_USER_WARNING);
    }
  }

  /**
   * Sets the source address.
   *
   * This element is for specifying the source address of the message.  During a "submit" operation, the source address is going to determine the originator of the message, or where the message looks like it came from. During a "deliver" operation, the source address is going to specify where the message came from.  For example, if the message was sent from a mobile phone, the source address would be the telephone number of the sender.
   *
   * CARRIER:
   *
   *During a "deliver" operation, the carrier attribute specifies which carrier id a message was sent from. This value will determine which operator a mobile handset belongs to. Simplewire has assigned a unique numeric code for each network operator. For example, T-Mobile in the United States has a unique value of 79 in Simplewire's network. Please refer to http://network.simplewire.com/ for a complete real-time list of all carriers and their network identification codes. Please note that Simplewire may or may not include this value with a "deliver" request. The value may be set to 0 which should be treated as if no carrier was included.
   *
   *This attribute should not be used during a "submit" operation.
   *
   * TYPE OF NETWORK (ton):
   *
   * The ton attribute specifies what type-of-number the network can expect to be used in the address attribute. Various types of addresses can be used in the address attribute. Supported address types and their ton values include:
   *
   * Based on the ton value, the address field may be interpreted differently.
   * Acceptable formats based on the ton value are:
   *
   * SMS_ADDR_TYPE_UNKNOWN - An unknown address means that the type isn't known beforehand
   *     and a best guess is performed by the network. Usually, addresses of this
   *     type look like +13135551212 where the format is +<country code><national number>.
   *
   * SMS_ADDR_TYPE_INTERNATIONAL - An international address is a fully qualified phone number.
   *     Its similar to an unknown address, but its format is
   *     <country code><national number>.  Please note there is no leading + character.
   *
   * SMS_ADDR_TYPE_NETWORK - A short code address is usually between 4 and 6
   *     digits in length. For example, 10900 or 1544 are short codes.
   *
   * SMS_ADDR_TYPE_ALPHANUMERIC - An alphanumeric address can contain digits or printable
   *     characters. Only some GSM mobile networks support alphanumeric addresses.
   *     For example, one could specify "Simplewire" to make the SMS look like it
   *     came from a sender called Simplewire. Useful for branding your SMS.
   *
   * @param Address $sourceAddr Address object that represents the new source address
   * @return int 0 if member variable is assigned, nonzero if there was a problem (incorrect type)
   * @see SMS::getSourceAddr()
   * @see Address::setType()
   * @see Address::setCarrier()
   * @see Address::setAddress()
   * @see SMS_ADDR_TYPE_UNKNOWN
   * @see SMS_ADDR_TYPE_INTERNATIONAL
   * @see SMS_ADDR_TYPE_NETWORK
   * @see SMS_ADDR_TYPE_ALPHANUMERIC
   */
  function setSourceAddr($sourceAddr) {
    $type = strtolower(getType($sourceAddr));
    $class = strtolower(get_class($sourceAddr));

    // check if setting it to null
    if (!isset($sourceAddr))
    {
        $this->m_SourceAddr = NULL;
    }
    else if ($type == "object" && $class == "address")
    {
      $this->m_SourceAddr = $sourceAddr;
    }
    else
    {
      trigger_error ("setSourceAddr requires Address object type", E_USER_WARNING);
    }
  }

  /**
   * Sets the debug mode, true turns it on, false turns it off.  Debug mode prints extra information as operations are performed
   *
   * @param bool $newMode bool that represents the new value of the debug mode
   * @return void
   * @see SMS::getDebugMode()
   */
  function setDebugMode($newMode){
    $this->m_Debug = (bool) $newMode;
  }


  //function setOptNetworkType($networkType) {
  //  // error check
  //  if ($networkType < 0 || $networkType > 3) {
  //    trigger_error ("setNetworkType only accepts values between 0-3, see constants", E_USER_ERROR);
  //  }
  //  $this->m_OptNetworkType = intval($networkType);
  //}

  /**
   * Set the type of content that is going to be dealt with
   *
   * @param integer $contentType One of the constants listed above
   * @return void
   * @see SMS::setContentType()
   * @see SMS_CONTENT_DATA
   * @see SMS_CONTENT_WAPPUSH
   */
  //function setContentType($contentType) {
  //  // error check
  //  if ($contentType < 0 || $contentType > 8) {
  //    trigger_error ("setContentType only accepts values between 0-8, see constants", E_USER_ERROR);
  //  }
  //  $this->m_OptContentType = intval($contentType);
  //}
  // * @return void
  // * @see SMS::getProtocolVersion()
  // * @see SMS_PROTOCOL_VERSION_2_0
  // * @see SMS_PROTOCOL_VERSION_3_0
  // */

  /**
   * Sets the protocol version of the message that is being sent to Simplewire.
   *
   * It takes an integer that is either SMS_PROTOCOL_VERISON_2_0 or SMS_PROTOCOL_VERSION_3_0
   *
   * @param int $protocolVersion integer that is one of the constants above
   * @return void
   */
  function setProtocolVersion($protocolVersion){
    $this->m_ProtocolVersion = $protocolVersion;
    if($protocolVersion == SMS_PROTOCOL_VERSION_2_0 ){
      $this->m_RequestProtocol = "paging";
      $this->m_RequestVersion = "2.0";
    }
    else {
      $this->m_RequestProtocol = "wmp";
      $this->m_RequestVersion = "3.0";
    }

  }

  /**
   * Parses the xml response from the server and populates all the necessary member variables.  This function also sets any error codes that were encountered.
   *
   * @parameter string $xml The XML string that needs to be parsed
   * @return bool True for success, false for failure
   */
  function parse ($xml){
	$rv = true;

    // create xml parser and setup handlers
    $this->xmlParser = xml_parser_create();
	xml_set_object($this->xmlParser, $this);
	//xml_set_object($this->xmlParser, $this);
    xml_set_element_handler($this->xmlParser, "_startElement", "_endElement");

    // try to parse this xml
    if (!xml_parse($this->xmlParser, $xml, true)){
	  $rv = false;
      $this->m_ErrorCode = 90;
      $this->m_ErrorDesc = "XML parsing error: " . xml_error_string(xml_get_error_code($this->xmlParser)) . " at line " . xml_get_current_line_number($this->xmlParser);
      echo $this->m_ErrorDesc . " \r\n";
   }

    xml_parser_free($this->xmlParser);
    // if we make it here, then the parsing probably worked
    return $rv;
  }

  //Comment template that marks all parsing functions as private
    /**#@+
      @access private
      */
  function _startElement($parser, $name, $attrs) {
    if (!strcasecmp($name, "response")){
      $this->_parseResponse($attrs);
    }
    else if (!strcasecmp($name, "request")){
      $this->_parseRequest($attrs);
    }
    else if(!strcasecmp($name, "error")){
      $this->_parseError($attrs);
    }
    else if(!strcasecmp($name, "status")){
      $this->_parseStatus($attrs);
    }
    else if(!strcasecmp($name, "option")){
      $this->_parseOption($attrs);
    }
    else if(!strcasecmp($name, "account") || !strcasecmp($name, "subscriber")){
      $this->_parseSubscriber($attrs);
    }
    else if(!strcasecmp($name, "message") || !strcasecmp($name, "page")){
      $this->_parsePage($attrs);
    }
    else if(!strcasecmp($name, "ticket")){
      $this->_parseTicket($attrs);
    }
    else if(!strcasecmp($name, "service")){
      //$this->parseCarrier($attrs);
    }
    else if(!strcasecmp($name, "source")){
      $this->_parseSource($attrs);
    }
    else if(!strcasecmp($name, "destination")){
      $this->_parseDestination($attrs);
    }
  }

  function _parseOption($attrs){
    while (list($key, $value) = each($attrs)) {
      if(!strcasecmp($key, "datacoding")){
        $this->m_OptDataCoding = strtoupper($value);
      }
      else {
        //if ($this->m_Debug) { echo "no handling for option attr $key = $value </br>"; }
      }
    }
    if($this->m_Debug){
      print("m_OptDataCoding = $this->m_OptDataCoding </br>");
    }
  }

  function _parseSource($attrs){
    // create new destination address if one doesn't exist
    if (!isset($this->m_SourceAddr)) {
      $this->m_SourceAddr = new Address;
    }

    while (list($key, $value) = each($attrs)) {
      if(!strcasecmp($key, "carrier")){
        //echo "setting carrier value\n";
        $this->m_SourceAddr->setCarrier($value);
      }
      else if(!strcasecmp($key, "ton")){
        $this->m_SourceAddr->setType($value);
      }
      else if(!strcasecmp($key, "address")){
        $this->m_SourceAddr->setAddress($value);
      }
      else {
        //echo "Some unknown attribute for source </br>";
      }
    }
    if($this->m_Debug){
      print("m_SourceAddr = Carrier: " . $this->m_SourceAddr->getCarrier() . "</br>");
      print("                  Type: " . $this->m_SourceAddr->getType() . "</br>");
      print("               Address: " . $this->m_SourceAddr->getAddress() . "</br>");
    }
  }

  function _parseDestination($attrs){
    // create new destination address if one doesn't exist
    if (!isset($this->m_DestinationAddr)) {
      $this->m_DestinationAddr = new Address;
    }

    while (list($key, $value) = each($attrs)) {
      if (!strcasecmp($key, "carrier")){
        $this->m_DestinationAddr->setCarrier($value);
      }
      else if (!strcasecmp($key, "ton")){
        $this->m_DestinationAddr->setType($value);
      }
      else if (!strcasecmp($key, "address")){
        $this->m_DestinationAddr->setAddress($value);
      }
      else {
        //echo "Some unknown attribute for Destination </br>";
      }
    }
    if($this->m_Debug){
      print("m_DestinationAddr = Carrier: $this->m_DestinationAddr->getCarrier()</br>");
      print("Type: $this->m_DestinationAddr->getType()</br>");
      print("Address: $this->m_DestinationAddr->getAddress()</br>");
    }
  }

  function _parseResponse($attrs) {
    while (list($key, $value) = each($attrs)) {
      if(!strcasecmp($key, "version")){
        $this->m_ResponseVersion = $value;
      }
      else if(!strcasecmp($key, "protocol")){
        $this->m_ResponseProtocol = $value;
      }
      else if(!strcasecmp($key, "type")){
        $this->m_ResponseType = $value;
      }
      else {
        //echo "Some unknown attribute for response </br>";
      }
    }
    if($this->m_Debug){
      print("m_ResponseVersion = $this->m_ResponseVersion </br>");
      print("m_ResponsProtocol = $this->m_ResponseProtocol </br>");
      print("m_ResponseType = $this->m_ResponseType </br>");
    }
  }

  function _parseRequest($attrs){
      while (list($key, $value) = each($attrs)) {
        if(!strcasecmp($key, "version")){
          $this->m_RequestVersion = $value;

          // make sure to fill in what protocol we are processing
          if(!strcasecmp($value, "2.0")){
            $this->setProtocolVersion(SMS_PROTOCOL_VERSION_2_0);
          // default to version 3.0, even if the version is higher
          } else {
            $this->setProtocolVersion(SMS_PROTOCOL_VERSION_3_0);
          }
        }
        else if(!strcasecmp($key, "protocol")){
          $this->m_RequestProtocol = $value;
        }
        else if(!strcasecmp($key, "type")){
          $this->m_RequestType = $value;
          // set the operation here - version 2.0 request types...
          if (!strcasecmp($value, "sendpage")) {
            $this->m_Op = SMS_OP_DELIVER;
          } else if (!strcasecmp($value, "deliver")) {
            $this->m_Op = SMS_OP_DELIVER;
          } else if (!strcasecmp($value, "notify")) {
            $this->m_Op = SMS_OP_NOTIFY;
          }
        }
        else {
          //echo "Some unknown attribute for Request </br>";
        }
       }
       if($this->m_Debug){
          print("m_RequestVersion = $this->m_RequestVersion </br>");
          print("m_RequestProtocol = $this->m_RequestProtocol </br>");
          print("m_RequestType = $this->m_RequestType </br>");
          print("m_Op = $this->m_Op </br>");
       }

  }

  function _parseError($attrs){
    while (list($key, $value) = each($attrs)) {
      if(!strcasecmp($key, "code")){
		$this->m_ErrorCode = $value;
      }
      else if(!strcasecmp($key, "description")){
        $this->m_ErrorDesc = $value;
      }
      else if(!strcasecmp($key, "resolution")){
        $this->m_ErrorResolution = $value;
      }
      else {
        //echo "Some unknown attribute for Error </br>";
      }
    }
       if($this->m_Debug){
          print("m_ErrorCode = $this->m_ErrorCode </br>");
          print("m_ErrorDesc = $this->m_ErrorDesc </br>");
          print("m_ErrorResolution = $this->m_ErrorResolution </br>");
       }
  }

  function _parseSubscriber($attrs){
    while (list($key, $value) = each($attrs)) {
      if(!strcasecmp($key, "id")){
        $this->m_SubscriberID = $value;
      }
      else if(!strcasecmp($key, "password")){
        $this->m_SubscriberPassword = $value;
      }
      else {
        //echo "Some unknown attribute for subscriber </br>";
      }
    }
    if($this->m_Debug){
      print("m_AccountId = $this->m_AccountId </br>");
      print("m_AccountPassword = $this->m_AccountPassword </br>");
    }
  }

  function _parsePage($attrs){
    while (list($key, $value) = each($attrs)) {
      if(!strcasecmp($key, "udhi")){
        if (!strcasecmp($value, "true")) {
            $this->m_UdhIndicator = true;
        } else {
            $this->m_UdhIndicator = false;
        }
      }
      else if(!strcasecmp($key, "pin")) {
        // create new destination address if one doesn't exist
        if (!isset($this->m_DestinationAddr)) {
          $this->m_DestinationAddr = new Address;
        }
        $this->m_DestinationAddr->setAddress($value);
      }
      else if(!strcasecmp($key, "from")) {
        $this->m_MsgFrom = $value;
      }
      else if(!strcasecmp($key, "callback")) {
        // create new source address if one doesn't exist
        if (!isset($this->m_SourceAddr)) {
          $this->m_SourceAddr = new Address;
        }
        $this->m_SourceAddr->setAddress($value);
      }
      else if(!strcasecmp($key, "text")) {
        $this->m_Text = $value;
        if ($this->m_ProtocolVersion == SMS_PROTOCOL_VERSION_2_0){
          // convert the text to bytes and set in data property
          // php already does this, so we'll just copy what we've got
          $this->m_Data = $value;
        }
      }
      //Depending on the format of the data, the text is set differently.  Different
      //Character encoding schemes can be used and care must bu used to properly
      //convert the character encoding scheme to a byte array
      else if (!strcasecmp($key, "data")){
        //This decodes the Hexadecimal string and converts it to a byte array
        $this->m_Data = pack("H*", $value);

        $offset = 0;
        $len = strlen($this->m_Data);

        if ($this->m_Debug){
            echo "Data Length = " . $len . "</br>";
        }

        if ($len > 1 && $this->m_UdhIndicator) {
          $offset = ord($this->m_Data[0]) + 1;
          if ($this->m_Debug){
            echo "UDH Offset = $offset</br>";
          }
        }

        if (!strcasecmp($this->m_OptDataCoding, "ucs2")){
          // this means that the string should be a Unicode string - Not supported at this moment
        } else {
          $this->m_Text = substr($this->m_Data, $offset, $len-$offset);
        }
      }
      else {
        //echo "Some unknown attribute for page or data </br>";
      }
    }
    if ($this->m_Debug){
      print("m_UdhIndicator = $this->m_UdhIndicator </br>");
      print("m_Text = $this->m_Text </br>");
      print("m_Data = $this->m_Data </br>");
    }
  }

  function _parseStatus($attrs){
    while (list($key, $value) = each($attrs)) {
      if (!strcasecmp($key, "code")){
        $this->m_StatusCode = intval($value);
      }
      else if (!strcasecmp($key, "description")){
        $this->m_StatusDesc= $value;
      }
      else {
        //echo "Some unknown attribute for Status </br>";
      }
    }
    if ($this->m_Debug){
      print("m_StatusCode = $this->m_MsgStatusCode</br>");
      print("m_StatusDesc = $this->m_MsgStatusDesc</br>");
    }
  }

  function _parseTicket($attrs){
    while (list($key, $value) = each($attrs)) {
      if(!strcasecmp($key, "id")) {
        $this->m_TicketId = $value;
      }
      else{
        //if ($this->m_Debug) { echo "no handling for ticket attr $key = $value </br>"; }
      }
    }
    if ($this->m_Debug){
      print("m_TicketId = $this->m_TicketId</br>");
    }
  }

  /* called when parsing the XML string and the end element is encountered */
  function _endElement($parser, $name){

  }
  /**#@-*/
    //End of the private functions template

} //End of class SMS

?>
