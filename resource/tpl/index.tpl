<form>
	
	<!-- hiiden -->
	<input type="hidden" name="seq" value="<?php echo $aData['seq'];?>" />
	<input type="hidden" name="active" value="<?php echo $aData['active'];?>" />
	<input type="hidden" name="datereg" value="<?php echo $aData['datereg'];?>" />

  <div class="section">
    <div class="mTitle">
        <h2>Set Product Review</h2>
    </div>
    
    <p class="mRequired"><strong class="txtMust">*</strong> Required Fields</p>
    	<div class="mBoard type2 gLarge">
    	 <table border="1" summary="">
	        <caption>Set Product Review</caption>
	        <tbody>
	            <tr>
	                <th scope="row">Review title <strong class="txtMust">*</strong></th>
	                <td><input type="text" class="fText" style="width:99%;" name="review_title" value="<?php echo $aData['review_title'];?>" validate="required" /></td>
	            </tr>
	            <tr>
	                <th scope="row">Subject displayed(max.125)</th>
	                <td><input type="text"  class="fText right" style="width:40px;" name="subject_char" value="<?php echo $aData['subject_char'];?>" validate="digits|intmax[125]"  /> characters</td>
	            </tr>
	            <tr>
	                <th scope="row">Product name displayed(max.125)</th>
	                <td><input type="text"  class="fText right" style="width:40px;" name="product_char" value="<?php echo $aData['product_char'];?>" validate="digits|intmax[125]" /> characters</td>
	            </tr>
	            <tr>
	                <th scope="row">Target of product link</th>
	                <td>
	                    <label class="fChk"><input type="radio" name="target" value="current" <?php echo ($aData['target'] === 'current') ? 'checked' : ''?> /> current window</label>
	                    <label class="fChk"><input type="radio" name="target" value="new" <?php echo ($aData['target'] === 'new') ? 'checked' : ''?>  /> new window</label>
	                </td>
	            </tr>
	            
	        </tbody>
	        </table>
	    </div>
	</div>
	
	<div class="mButton">
	    <p>
	        <a href="javascript:void(0);" class="btnSubmit"><span>Save</span></a>
	        <a href="#none" class="btnCancel"><span>Cancel</span></a>
	    </p>
	</div>
    
    
    </form>
       

<pre>
	<?php //var_dump($aData);?>
</pre>

