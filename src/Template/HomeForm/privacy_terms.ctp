<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;
use App\Controller;
use App\DTO;
use Cake\Network;

$this->layout = false;


?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>PrivacyTerms</title>

		<meta name="viewport" content="width=device-width; initial-scale=1.0"/>
                <?= $this->Html->css('vibeosys.css')?>
        
	</head>
	<body >
		<div class="wrap">
		<div class = "page-head"><h2>PrivacyTerms</h2></div>
<div class = "wrapeer">
<div class = "content">
<div class = "heading">
<h4>What kinds of information do we collect?</h4>
</div>
<div class = "data">
<ul>

<li><span>Depending on which Services you use, we collect different kinds of information from or about you.</span></li></br>
<li><span>Things you do and information you provide.</span></li>
<ul><p><li>We collect the content and other information you provide when you use our Services, including when you sign up for an account,</br> 
create or share, and message or communicate with others.</li>
<li>This can include information in or about the content you provide, such as the location of a photo or the date a file was created.</li>
<li>We also collect information about how you use our Services, such as the types of content you view or engage with or the frequency </br>
and duration of your activities.</li></p></ul>

<li><span>Things others do and information they provide.</span></li>

<ul><p><li>We also collect content and information that other people provide when they use our Services, including information about you,</br> 
such as when they share a photo of you, send a message to you, or upload, sync or import your contact information.</li></p></ul>
<li><span>Your networks and connections.</span></li>
<ul><p><li>We collect information about the people and groups you are connected to and how you interact with them, such as the people you </br>
communicate with the most or the groups you like to share with. We also collect contact information you provide if you upload, sync </br>
or import this information (such as an address book) from a device.</li></p></ul>

<li><span>Device information.</span></li>
<ul><p><li>
We collect information from or about the computers, phones, or other devices where you install or access our Services, depending on </br>
the permissions you've granted.</li>
<li> We may associate the information we collect from your different devices, which helps us provide consistent Services across your devices.</li>
<li> Here are some examples of the device information we collect: </li>
<ul>
<li>Attributes such as the operating system, hardware version, device settings, file and software names and types, battery and signal </br>
strength, and device identifiers.</li>
<li>Device locations, including specific geographic locations, such as through GPS, Bluetooth, or WiFi signals.</li>
<li>Connection information such as the name of your mobile operator or ISP, browser type, language and time zone, mobile phone number </br>
and IP address.</li></br></ul></ul>

<li><span>Information from third-party partners.</span></li>
<ul><p><li>We receive information about you and your activities on and off from third-party partners, such as information from a partner when </br>
we jointly offer services or from an advertiser about your experiences or interactions with them.</li></p></ul>
</ul>
</div>
</div>
<div class = "content">
<div class = "heading">
<h4>How do we use this information?</h4>
</div>
<div class = "data">
<ul>
<li><span>We are passionate about creating engaging and customized experiences for people.</span></li> </br>
<li><span>We use all of the information we have to help us provide and support our Services.</span> </li></br>
<li><span>Here's how:<span></li></br>
<ul>
<li>Provide</li>
<li>improve</li>
<li>develop Services</li></br>
</ul>

<li>We are able to deliver our Services, personalize content, and make suggestions for you by using this information to understand how you use </br>
and interact with our Services and the people or things you’re connected to and interested in on and off our Services. </li></br>

<li>When we have location information, we use it to tailor our Services for you and others, like helping you to check-in and find local events </br>
or offers in your area or tell your friends that you are nearby. </li></br>

<li>We conduct surveys and research, test features in development, and analyze the information we have to evaluate and improve products and </br>
services, develop new products or features, and conduct audits and troubleshooting activities.</li>
</br>
<li>Communicate with you.</li>
<ul><p>
<li>We use your information to send you marketing communications, communicate with you about our Services and let you know about our policies </br>and terms. </li>
<li>We also use your information to respond to you when you contact us.</li>
</p></ul>

<li>Show and measure ads and services.</li>
<ul><p>
<li>
We use the information we have to improve our advertising and measurement systems so we can show you relevant ads on and off our Services and </br>measure </br>
the effectiveness and reach of ads and services.</li> 
<li>Learn more about advertising on our Services and how you can control how information about you is used to personalize the ads you see.</li></br>
</ul>

<li>Promote safety and security.</li>
<ul><p><li>
We use the information we have to help verify accounts and activity, and to promote safety and security on and off of our Services, such as by </br>
investigating suspicious activity or violations of our terms or policies. </li>
<li>We work hard to protect your account using teams of engineers, automated systems, and advanced technology such as encryption and machine learning. </li>
<li>We also offer easy-to-use security tools that add an extra layer of security to your account.</li></br></ul>

<li>Sharing On Our Services</li>
<ul><p><li>
People use our Services to connect and share with others. </li>
<li>We make this possible by sharing your information in the following ways:</li></br>
<ul><li>
People you share and communicate with.</li>
<li>When you share and communicate using our Services, you choose the audience who can see what you share. </li>
<li>For example, when you post, you select the audience for the post, such as a customized group of individuals, all of your Friends, or members of</br> a Group. </li></ul><p></ul>

<li>People that see content others share about you.</li></br>
<ul><li>
Other people may use our Services to share content about you with the audience they choose. 
</li><li>For example, people may share a photo of you, mention or tag you at a location in a post, or share information about you that you shared with </br>them. 
</li></br>
</ul>

<li>Apps, websites and third-party integrations on or using our Services.</li>
<ul><li>
When you use third-party apps, websites or other services that use, or are integrated with, our Services, they may receive information about</br> what you post or share. </li></ul>
</ul>
</div>
</div>
</div>
		</div>
		<hr class="separator"/>
		 <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0.0
                </div>
                <strong>Copyright &copy; 2015-2016 <a href="#"><span class="app-name"><i> Safar<span class="app-name-select"> Ka Sathi </span></i></span></a></strong> All rights reserved.
            </footer>
		
		
		

	</body>
</html>