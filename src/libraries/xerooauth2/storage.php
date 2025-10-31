<?php
class StorageClass
{
	function __construct() {
		if( !isset($_SESSION) ){
        	$this->init_session();
    	}
   	}

   	public function init_session(){
    	session_start();
	}

    public function getSession() {
    	include(dirname(__FILE__) .'/accessdata.php');
    	$stl_xero_oauth2 = array(
	        'token' => $stl_xero_access_token,
	        'expires' => $stl_xero_access_expire,
	        'tenant_id' => $stl_xero_access_tenantid,
	        'refresh_token' => $stl_xero_refresh_token
	    );

		return $stl_xero_oauth2;

    	// return $_SESSION['oauth2'];
    }

 	public function startSession($token, $secret, $expires = null)
	{
       	session_start();
	}

	public function setToken($token, $expires = null, $tenantId, $refreshToken)
	{    

		$access_token_str = var_export($token, true);
		$access_expire_str = var_export($expires, true);
		$access_tenantid_str = var_export($tenantId, true);
		$refresh_token_str = var_export($refreshToken, true);

		// $oauth2_value = array('oauth2' => array(
	 //        'token' => $token,
	 //        'expires' => $expires,
	 //        'tenant_id' => $tenantId,
	 //        'refresh_token' => $refreshToken
	 //    ));
		// $oauth2_value = serialize($oauth2_value);
		// $oauth2_value = var_export($oauth2_value, true);
		$var = "<?php\n\n\$stl_xero_access_token = $access_token_str;\n\$stl_xero_access_expire=$access_expire_str;\n\$stl_xero_access_tenantid=$access_tenantid_str;\n\$stl_xero_refresh_token=$refresh_token_str;\n\n?>";
		file_put_contents(dirname(__FILE__) .'/accessdata.php', $var);



	    // $_SESSION['oauth2'] = [
	    //     'token' => $token,
	    //     'expires' => $expires,
	    //     'tenant_id' => $tenantId,
	    //     'refresh_token' => $refreshToken
	    // ];
	}

	public function getToken()
	{
		include(dirname(__FILE__) .'/accessdata.php');
	    //If it doesn't exist or is expired, return null
	    if (!empty($this->getSession())
	        || ($stl_xero_access_expire !== null
	        && $stl_xero_access_expire <= time())
	    ) {
	        return null;
	    }
	    return $this->getSession();
	}

	public function getAccessToken()
	{
		include(dirname(__FILE__) .'/accessdata.php');
	    return $stl_xero_access_token;
	}

	public function getRefreshToken()
	{
		include(dirname(__FILE__) .'/accessdata.php');
	    return $stl_xero_refresh_token;
	}

	public function getExpires()
	{
		include(dirname(__FILE__) .'/accessdata.php');
	    return $stl_xero_access_expire;
	}

	public function getXeroTenantId()
	{
		include(dirname(__FILE__) .'/accessdata.php');
	    return $stl_xero_access_tenantid;
	}

	public function getHasExpired()
	{
		if (!empty($this->getSession())) 
		{
			if(time() > $this->getExpires())
			{
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
}
?>
