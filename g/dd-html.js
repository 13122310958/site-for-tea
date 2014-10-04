<form id="wfform" name="wfform" action="../order/index.php" method="post" onSubmit="return postcheck()">
<input type="hidden" name="price" value="199" />
<input type="hidden" name="userid" value="10909">
<table>
<tr><td class="label">收货人姓名：</td><td><input type="text" name="dgname" size="8"> 一律填写中文姓名</td></tr>
<tr><td class="label">收货人地址：</td><td><input type="text" name="address" class="form-text"><br>（请尽量填写详细，以便工作人员派送 ）</td></tr>
<tr><td class="label">l联系电话：</td><td><input type="text" name="mob" class="form-text"></td></tr>
<tr><td colspan="2">（请务必填写手机号码，以方便我们与您联系）</td></tr>
<tr><td class="label">支付方式：</td><td>
							<input type="radio" checked="checked" name="paytype" id="paytypea" value="货到付款" class="dxk"><label for="paytypea">货到付款</label>							
					</td></tr>
<tr><td class="label">套餐选择：</td><td><select name="product"  class="selecta">
							<option selected="selected" value="曲线茶：A款 一盒体验装 199元|199">：A款 一盒体验装 199元</option>
							<option value="曲线茶：B款 汉方养瘦（一个疗程）三盒装 398元|398">：B款 汉方养瘦（一个疗程）三盒装 398元</option>
							<option value="曲线茶：C款 速效瘦身（二个疗程）六盒装 698元|698">：C款 速效瘦身（二个疗程）六盒装 698元</option>
							<option value="曲线茶：D款 终极瘦身（三个疗程）九盒装898元|898">：D款 终极瘦身（三个疗程）九盒装898元</option>
						</select></td></tr>
<tr>
	<td class="label">留言备注：</td><td><textarea name="guest" onFocus="if(value=='请尽量在星期天送货，送货之前手机联系，谢谢！'){value=''}" onBlur="if (value ==''){value='请尽量在星期天送货，送货之前手机联系，谢谢！'}" class="guest kda">请尽量在星期天送货，送货之前手机联系，谢谢！</textarea></td>
</tr>
<tr><td class="label">验证码：</td><td><input type="text" name="usercode" class="txt txt2"><img src="../order/vcode.php" alt="看不清，请点击刷新" title="看不清，请点击刷新" onClick="this.src='../order/vcode.php?'+Math.random()"></td></tr>
<tr><td colspan="2" align="center"><input type="image" src="images/orderbtn_2.png">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/reset_btn.png"></td></tr>
</table>
<input type="hidden" name="f_mobile" value="1">
</form>