

<div id="wforder">
    <form id="wfform" name="wfform" action="order/index.php" method="post" onsubmit="return postcheck()" target="_parent">
	    <input type="hidden" name="cpmun"  value="1" />
<input type="hidden" name="userid" value="10909">
		<input type="hidden" name="price" value="199" />
		<div class="wftitle"><img src="order/images/tita.gif" /></div>
		<div class="bdbox">
		    <ul>
				<li class="product">
				    <span class="bdl"><em>*</em>产品套餐</span>
					<span class="bdr red">
						<select name="product" onChange="oprize2()" class="selecta">
							<option selected="selected" value="曲线茶：A款 一盒体验装 199元|199">：A款 一盒体验装 199元</option>
							<option value="曲线茶：B款 汉方养瘦（一个疗程）三盒装 398元|398">：B款 汉方养瘦（一个疗程）三盒装 398元</option>
							<option value="曲线茶：C款 速效瘦身（二个疗程）六盒装 698元|698">：C款 速效瘦身（二个疗程）六盒装 698元</option>
							<option value="曲线茶：D款 终极瘦身（三个疗程）九盒装898元|898">：D款 终极瘦身（三个疗程）九盒装898元</option>
						</select>
					</span>
				</li>
				<li><span class="bdl"><em>*</em>收货人姓名</span><span class="bdr"><input type="text" name="dgname" class="txt kda1" />一律填写中文姓名</span></li>
				
				
				<li><span class="bdl"><em>*</em>手机号码</span><span class="bdr"><input type="text" name="mob" class="txt kda2" /></span></li>
				<li>（请务必填写手机号码，以方便我们与您联系，如13588888888）</li>
				<li><span class="bdl"><em>*</em>所在地区</span><span class="bdr"><select name="province" onChange="diqu()" class="selectb"></select><select name="city" onChange="diqu()" class="selectb"></select><select name="area" onChange="diqu()" class="selectb"></select></span></li>
				<li><span class="bdl"><em>*</em>详细地址</span><span class="bdr"><input type="text" name="address" id="address" class="txt kda" /></span></li>
				<li> 请尽量填写详细，以便工作人员派送 ！ 如（上海市浦东新区**路**号**大厦**室） </li>
				<li class="pay">
					<span class="bdl"><em>*</em>付款方式</span>
					<span class="bdr">
					<div class="payaa">
							<input type="radio" checked="checked" name="paytype" id="paytypea" value="货到付款" onclick="opay();return changeItem(0);" class="dxk" /><label for="paytypea">货到付款</label>
							
					</div>
						<div id="paydiv0" class="paybb kda">
							<p>提示:此信息将打印在快递面上,作为快递公司送货依据!</p>
							<p>请尽量填写详细,个别地区可能会有延迟,敬请谅解!</p>
						</div>
						<div id="paydiv1" class="paybb kda" style="display:none;">					
							<p>温馨提示：支付宝付款方便快捷！</p>
							<p>全球领先的第三方支付平台，在线支付，安全可靠！</p>							
						</div>
						<div id="paydiv2" class="paybb kda" style="display:none;">
							
						</div>
					</span>
				</li>
				<li class="guest"><span class="bdl">留言</span><span class="bdr"><textarea name="guest" onfocus="if(value=='请尽量在星期天送货，送货之前手机联系，谢谢！'){value=''}" onblur="if (value ==''){value='请尽量在星期天送货，送货之前手机联系，谢谢！'}" class="guest kda">请尽量在星期天送货，送货之前手机联系，谢谢！</textarea></span></li>
				<li class="code"><span class="bdl"><em>*</em>验证码</span><span class="bdr"><input type="text" name="usercode" class="txt txt2" /><img src="order/vcode.php" alt="看不清，请点击刷新" title="看不清，请点击刷新" onClick="this.src=this.src+'?'" /></span></li>
				<li class="sub"><input type="submit" name="wfsubmit" value="" class="send" /></li>
			</ul>
		</div>
	</form>
</div>
