<div style="background: black; width:100%; padding:10px; border:solid; border-radius:5px;">
    <img src="https://i.ibb.co/sv7c7d7/output-onlinepngtools.png" alt="RUBI">
</div>
<hr><br>
<h3>BUSINESS VERIFICATION</h3>
<p>Thank you for registering <b>{{ $name }}</b> with RUBI. Please click <i>Verify</i> below to get your business account verified and start working.</p>
<br>
<p><a href="{{ url('/verifyBusiness') }}/{{ $businessNo }}" id="btnVerify" style="text-decoration:none; width:60%; padding:10px; font-size:20px; border:solid; border-radius:8px; background:rgb(228, 53, 0); color:white;"><b>VERIFY</b></a></p>
<br>
<p style="color:red">Note: If you fail to verify, your account will be deleted within 24 hours.</p>