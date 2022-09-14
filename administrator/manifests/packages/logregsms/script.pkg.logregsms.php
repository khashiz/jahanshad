<?php

/**
 * @package    JoominaMarket SMS LogRegSms
 * @author     Mohamad Hosein Miri {@link JoominaMarket.com}
 * @author     Created on 21-Sep-2018
 * @license    GNU/GPL
 */

defined('_JEXEC') or die('Restricted access');

//ini_set('display_errors', TRUE);
//error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
class pkg_logregsmsInstallerScript {  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	 
	
    function postflight($action, $installer)  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    {
	
    if ($action == "install") {  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    } ?>
		
<style>
	.install-ok {
	background: #7dc35b;
	color: #fff;
	padding: 3px;
}

.install-not-ok {
	background: #E9452F;
	color: #fff;
	padding: 3px;
}
</style>
	<div class="row-fluid">
		<div class="span12">
			<p>کامپوننت ثبت نام و لاگین پیامکی جوملا 
				<b class="install-ok">نصب شد</b>
			</p>
			<p>پلاگین بستن ثبت نام و لاگین جوملا
				<b class="install-ok">نصب شد</b>
			</p>
			<p>پلاگین تغییر نام کاربری جوملا
				<b class="install-ok">نصب شد</b>
			</p>
			<p>ماژول لاگین و ثبت نام پیامکی جوملا
				<b class="install-ok">نصب شد</b>
			</p>
			
			<p>
			<a class="btn btn-primary btn-large" href="index.php?option=com_logregsms"
			>شروع استفاده از کامپوننت لاگین . ثبت نام پیامکی جوملا</a>
			</p>
			
			<p>
			<a class="" href="http://www.joominamarket.com"
			>برنامه نویسی شده توسط تیم برنامه نویسی جومینا مارکت - www.joominamarket.com</a>
			</p>
		</div>
	</div>

<?php }

}