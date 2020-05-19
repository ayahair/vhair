<?php
$_['heading_title_seo']     = 'SEO Bulk Generator';

$_['text_success']     			= 'Success: You have updated the changes!';

$_['text_header_product']    	= '<i class="fa fa-flask"></i> SEO for Product Pages ';
$_['text_header_category']    	= '<i class="fa fa-flask"></i> SEO for Category Pages ';
$_['text_header_brand']      	= '<i class="fa fa-flask"></i> SEO for Brand Pages  ';
$_['text_header_information']   = '<i class="fa fa-flask"></i> SEO for Information Pages ';


$_['col_process_name']  	= 'Process';
$_['col_process_guide'] 	= 'Guide';
$_['col_process_parameter'] = 'Parameter Pattern';
$_['col_process_action']  	= 'Action';
$_['col_automation']  		= 'Execute Automatic Generation Script When adding/editing - product/category/information/manufacturer';

$_['col_title']  	 = 'Title Tag';
$_['col_h1']   		 = 'H1 Tag';
$_['col_h2']  		 = 'H2 Tag';
$_['col_img_alt']    = 'Image Alt Tag';
$_['col_meta_desc']  = 'Meta-Description Tag';
$_['col_meta_key']   = 'Meta-Keyword Tag';
$_['col_description']  = 'Brand Description';

$_['btn_generate']  	 = '<i class="fa fa-play-circle"></i> Generate';
$_['btn_clear']  	 	 = '<i class="fa fa-trash"></i>  Clear';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify this extension!';


///GUIDE////
$_['guide1'] = 'Title tag appears in your web browser tab/header. Also title tag appears in search engines result pages as heading. Use the below available shortcode variables in this title tag field.<br>
<ol>
	<li><b>Product Name/Title:</b> {p}</li>
	<li><b>Product Model:</b> {m}</li>
	<li><b>Product Brand/Manufacturer:</b> {b}</li>
	<li><b>Assigned Product Categories</b> {c}</li>
	<li><b>UPC</b> {u}</li>
</ol>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your title tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Buy {p} | {b} | MyStore.com &nbsp;</span></strong><span style="line-height: 1.6;">, for Product </span><strong style="line-height: 1.6;">iPhone</strong><span style="line-height: 1.6;"> it will generate title tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Buy iPhone | Apple | MyStore.com</span></strong></p>
';

$_['guide2'] = 'Each web page should contain only one H1(Heading 1) Tag. Using main keyword in this tag help search engines to better understand the content of the page. Use the below available shortcode variables in this H1 Tag field.<br>
<ol>
	<li><b>Product Name/Title:</b> {p}</li>
	<li><b>Product Model:</b> {m}</li>
	<li><b>Product Brand/Manufacturer:</b> {b}</li>
	<li><b>Assigned Product Categories</b> {c}</li>
	<li><b>UPC</b> {u}</li>
</ol>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your h1 tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">{p} (Brand: {b}) &nbsp;</span></strong><span style="line-height: 1.6;">, for Product </span><strong style="line-height: 1.6;">iPhone</strong><span style="line-height: 1.6;"> it will generate h1 tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">iPhone (Brand: Apple)</span></strong></p>
';

$_['guide3'] = 'Each web page should contain at least one H2(Heading 2) Tag. Using main keyword in this tag help search engines to better understand the descriptive content of the page. Use the below available shortcode variables in this H2 Tag field.<br>
<ol>
	<li><b>Product Name/Title:</b> {p}</li>
	<li><b>Product Model:</b> {m}</li>
	<li><b>Product Brand/Manufacturer:</b> {b}</li>
	<li><b>Assigned Product Categories</b> {c}</li>
	<li><b>UPC</b> {u}</li>
</ol>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your h2 tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Buy {p} | {b} | {c} </span></strong><span style="line-height: 1.6;">, for Product </span><strong style="line-height: 1.6;">iPhone</strong><span style="line-height: 1.6;"> it will generate h2 tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Buy iPhone | Apple | Desktops | Phones & PDAs</span></strong></p>
';

$_['guide4'] = 'Use the below available shortcode variables in this image (alt) alternative Tag field.<br>
<ol>
	<li><b>Product Name/Title:</b> {p}</li>
	<li><b>Product Model:</b> {m}</li>
	<li><b>Product Brand/Manufacturer:</b> {b}</li>
	<li><b>Assigned Product Categories</b> {c}</li>
	<li><b>UPC</b> {u}</li>
</ol>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your image alt tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">{p} image</span></strong><span style="line-height: 1.6;">, for Product </span><strong style="line-height: 1.6;">iPhone</strong><span style="line-height: 1.6;"> it will generate iamge alt tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">iPhone image</span></strong></p>
';

$_['guide5'] = 'Use the below available shortcode variables in this meta-description Tag field.<br>
<ol>
	<li><b>Product Name/Title:</b> {p}</li>
	<li><b>Product Model:</b> {m}</li>
	<li><b>Product Brand/Manufacturer:</b> {b}</li>
	<li><b>Assigned Product Categories</b> {c}</li>
	<li><b>UPC</b> {u}</li>
</ol>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your meta-description tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Buy {p}, {b} from MyStore.com. Fast & Free Home Delivery. High Quality Service</span></strong><span style="line-height: 1.6;">, for Product </span><strong style="line-height: 1.6;">iPhone</strong><span style="line-height: 1.6;"> it will generate meta-description tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Buy iPhone, Apple from MyStore.com. Fast & Free Home Delivery. High Quality Service</span></strong></p>
';

$_['guide6'] = 'This extension has a special algorithm which will convert non-english characters to its equivalent SEO friendly characters.<br>
<br>
<hr>
<h4>Parameters:</h4>
Use the below available shortcode variables in this meta-keyword Tag field. 
<ol>
	<li><b>Product Name/Title:</b> {xp}</li>
	<li><b>Product Model:</b> {xm}</li>
	<li><b>Product Brand/Manufacturer:</b> {xb}</li>
	<li><b>Assigned Product Categories</b> {xc}</li>
	<li><b>UPC</b> {xu}</li>
</ol>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your meta-keyword tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">buy {xp}, buy {xp} online, online shopping {xp}, {xc}, {xc} {xp}, {xb} {xp} {xm}, quality {xp} {xc}, best price {xp}, less price {xp}</span></strong><span style="line-height: 1.6;">, for Product </span><strong style="line-height: 1.6;">iPhone</strong><span style="line-height: 1.6;"> it will generate meta-keyword tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">buy iphone, buy iphone online, online shopping iphone, desktops | phones & pdas, desktops | phones & pdas iphone, apple iphone product 11, quality iphone desktops | phones & pdas, best price iphone, less price iphone</span></strong></p>
';

$_['guide7'] = 'Title tag appears in your web browser tab/header. Also title tag appears in search engines result pages as heading. Use the below available shortcode variables in this title tag field.<br>
<ul>
	<li><b>Category Name/Title:</b> {cn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your title tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Buy Best {cn} Products from MyStore.com</span></strong><span style="line-height: 1.6;">, for category </span><strong style="line-height: 1.6;">Cameras</strong><span style="line-height: 1.6;"> it will generate title tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Buy Best Cameras Products from MyStore.com</span></strong></p>
';

$_['guide8'] = 'Each web page should contain only one H1(Heading 1) Tag. Using main keyword in this tag help search engines to better understand the content of the page. Use the below available shortcode variables in this H1 Tag field.<br>
<ul>
	<li><b>Category Name/Title:</b> {cn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your h1 tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Best {cn} products</span></strong><span style="line-height: 1.6;">, for category </span><strong style="line-height: 1.6;">Cameras</strong><span style="line-height: 1.6;"> it will generate h1 tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Best Cameras products</span></strong></p>
';

$_['guide9'] = 'Each web page should contain at least one H2(Heading 2) Tag. Using main keyword in this tag help search engines to better understand the descriptive content of the page. Use the below available shortcode variables in this H2 Tag field.<br>
<ul>
	<li><b>Category Name/Title:</b> {cn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your h2 tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Buy best and quality {cn} products</span></strong><span style="line-height: 1.6;">, for Category </span><strong style="line-height: 1.6;">Cameras</strong><span style="line-height: 1.6;"> it will generate h2 tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Buy best and quality Cameras products</span></strong></p>
';

$_['guide10'] = 'Use the below available shortcode variables in this image (alt) alternative Tag field.<br>
<ul>
	<li><b>Category Name/Title:</b> {cn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your image alt tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">{cn} images</span></strong><span style="line-height: 1.6;">, for category </span><strong style="line-height: 1.6;">Cameras</strong><span style="line-height: 1.6;"> it will generate image alt tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Cameras images</span></strong></p>
';

$_['guide11'] = 'Use the below available shortcode variables in this meta-description Tag field.<br>
<ul>
	<li><b>Category Name/Title:</b> {cn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your meta-description tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Buy best and quality {cn} products at less price only from MyStore.com. Fast and free home delivery.</span></strong><span style="line-height: 1.6;">, for category </span><strong style="line-height: 1.6;">Cameras</strong><span style="line-height: 1.6;"> it will generate meta-description tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Buy best and quality Cameras products at less price only from MyStore.com. Fast and free home delivery.</span></strong></p>
';

$_['guide12'] = 'This extension has a special algorithm which will convert non-english characters to its equivalent SEO friendly characters.<br>
<br>
<hr>
<h4>Parameters:</h4>
Use the below available shortcode variables in this meta-keyword Tag field. 
<ul>
	<li><b>Category Name/Title:</b> {xcn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your meta-keyword tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">buy {xcn}, buy {xcn} products, best {xcn} products, low price {xcn}, high quality {xcn} products, online {xcn} products, buy {xcn} online</span></strong><span style="line-height: 1.6;">, for category </span><strong style="line-height: 1.6;">Cameras</strong><span style="line-height: 1.6;"> it will generate meta-keyword tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">buy Cameras, buy Cameras products, best Cameras products, low price Cameras, high quality Cameras products, online Cameras products, buy Cameras online</span></strong></p>
';
$_['guide13'] = 'Title tag appears in your web browser tab/header. Also title tag appears in search engines result pages as heading. Use the below available shortcode variables in this title tag field.<br>
<ul>
	<li><b>Brand/Manufacturer Name/Title:</b> {bn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your title tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Buy Best {bn} Products from MyStore.com</span></strong><span style="line-height: 1.6;">, for brand </span><strong style="line-height: 1.6;">Apple</strong><span style="line-height: 1.6;"> it will generate title tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Buy Best Apple Products from MyStore.com</span></strong></p>
';

$_['guide14'] = 'Each web page should contain only one H1(Heading 1) Tag. Using main keyword in this tag help search engines to better understand the content of the page. Use the below available shortcode variables in this H1 Tag field.<br>
<ul>
	<li><b>Brand/Manufacturer Name/Title:</b> {bn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your h1 tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Best {bn} products</span></strong><span style="line-height: 1.6;">, for brand </span><strong style="line-height: 1.6;">Apple</strong><span style="line-height: 1.6;"> it will generate h1 tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Best Apple products</span></strong></p>
';

$_['guide15'] = 'Each web page should contain at least one H2(Heading 2) Tag. Using main keyword in this tag help search engines to better understand the descriptive content of the page. Use the below available shortcode variables in this H2 Tag field.<br>
<ul>
	<li><b>Brand/Manufacturer Name/Title:</b> {bn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your h2 tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Buy best and quality {bn} products</span></strong><span style="line-height: 1.6;">, for brand </span><strong style="line-height: 1.6;">Apple</strong><span style="line-height: 1.6;"> it will generate h2 tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Buy best and quality Apple products</span></strong></p>
';


$_['guide16'] = 'Use the below available shortcode variables in this meta-description Tag field.<br>
<ul>
	<li><b>Brand/Manufacturer Name/Title:</b> {bn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your meta-description tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">Buy best and quality {bn} products at less price only from MyStore.com. Fast and free home delivery.</span></strong><span style="line-height: 1.6;">, for brand </span><strong style="line-height: 1.6;">Apple</strong><span style="line-height: 1.6;"> it will generate meta-description tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">Buy best and quality Apple products at less price only from MyStore.com. Fast and free home delivery.</span></strong></p>
';

$_['guide17'] = 'This extension has a special algorithm which will convert non-english characters to its equivalent SEO friendly characters.<br>
<br>
<hr>
<h4>Parameters:</h4>
Use the below available shortcode variables in this meta-keyword Tag field. 
<ul>
	<li><b>Brand/Manufacturer Name/Title:</b> {bn}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your meta-keyword tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">buy {xbn}, buy {xbn} products, best {xbn} products, low price {xbn}, high quality {xbn} products, online {xbn} products, buy {xbn} online</span></strong><span style="line-height: 1.6;">, for brand </span><strong style="line-height: 1.6;">Apple</strong><span style="line-height: 1.6;"> it will generate meta-keyword tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">buy apple, buy apple products, best apple products, low price apple, high quality apple products, online apple products, buy apple online</span></strong></p>
';


$_['guide18'] = 'Title tag appears in your web browser tab/header. Also title tag appears in search engines result pages as heading. Use the below available shortcode variables in this title tag field.<br>
<ul>
	<li><b>Information Page Title:</b> {in}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your title tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">{in} | MyStore.com</span></strong><span style="line-height: 1.6;">, for information page </span><strong style="line-height: 1.6;">About us</strong><span style="line-height: 1.6;"> it will generate title tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">About us | MyStore.com</span></strong></p>
';


$_['guide19'] = 'Use the below available shortcode variables in this meta-description Tag field.<br>
<ul>
	<li><b>Information Page Title:</b> {in}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your meta-description tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">{in} | MyStore.com. Best Products, Best Price, Best Quality, Free Home Delivery</span></strong><span style="line-height: 1.6;">, for information page </span><strong style="line-height: 1.6;">About us</strong><span style="line-height: 1.6;"> it will generate meta-description tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">About us | MyStore.com. Best Products, Best Price, Best Quality, Free Home Delivery</span></strong></p>
';

$_['guide20'] = 'This extension has a special algorithm which will convert non-english characters to its equivalent SEO friendly characters.<br>
<br>
<hr>
<h4>Parameters:</h4>
Use the below available shortcode variables in this meta-keyword Tag field. 
<ul>
	<li><b>Information Page Title:</b> {xin}</li>
</ul>

<p><b style="line-height: 1.6;"><u>Example:</u></b><span style="line-height: 1.6;">&nbsp;If you set your meta-keyword tag parameter field to</span><b style="line-height: 1.6;">&nbsp;</b><strong style="line-height: 1.6;"><span style="color:#008000;">{xin}, {xin} information, {xin} mystore.com, best products, best quality products</span></strong><span style="line-height: 1.6;">, for information page </span><strong style="line-height: 1.6;">About us</strong><span style="line-height: 1.6;"> it will generate meta-keyword tag like </span><strong style="line-height: 1.6;"><span style="color:#008080;">about us, about us information, about us mystore.com, best products, best quality products</span></strong></p>';
?>