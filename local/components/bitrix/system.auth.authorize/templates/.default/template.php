<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?
$APPLICATION->SetAdditionalCss(SITE_TEMPLATE_PATH . '/css/validatorObject.css');
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>

<?if(isset($_GET['captcha_failed'])):?>
<p>
    <font class="errortext"><?=GetMessage('CAPTCHA_FAILED');?></font>
</p>
<?elseif(isset($_GET['undefined_email'])):?>
<p>
    <font class="errortext"><?=GetMessage('UNDEFINED_EMAIL');?></font>
</p>
<?endif;?>

<div id="authorizate-wrapper">
    <form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
        <input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach?>
        
        <div class="authorizate-headline"><?=GetMessage('AUTHORIZATE_HEADLINE');?></div>
        <section class="authorizate-section">
            <div class="authorizate-section-question"><span><?=GetMessage('AUTHORIZATE_LOGIN');?>:</span><span class="required"></span></div>
            <div class="authorizate-section-answer">
                <input type="text" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" class="authorizate-input"/>
            </div>
        </section>
        <section class="authorizate-section">
            <div class="authorizate-section-question"><span><?=GetMessage('AUTHORIZATE_PASSWORD');?>:</span><span class="required"></span></div>
            <div class="authorizate-section-answer">
                <input type="password" name="USER_PASSWORD" autocomplete="off" class="authorizate-input"/>
            </div>
        </section>
        <?if($arResult["CAPTCHA_CODE"]):?>
            <section class="authorizate-section">
            <div class="authorizate-section-captcha">
                <input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
                <img src="/local/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>&SET_BORDER_COLOR=33,124,138" alt="CAPTCHA" />
            </div>
            <div class="authorizate-section-question"><span><?=GetMessage('AUTHORIZATE_CAPTCHA');?>:</span><span class="required"></span></div>
            <div class="authorizate-section-answer">
                <input type="text" name="captcha_word" class="authorizate-input"/>
            </div>
            </section>
        <?endif;?>
        <section class="authorizate-section">
            <input type="submit" value="Войти" class="authorizate-submit-button animated" />
            
            <script type="text/javascript">
                $(window).ready(function()
                {
                    var authorizateSubmitButton = $('.authorizate-submit-button');
                    
                    authorizateSubmitButton.hover(
                    function()
                    {
                        $(this).addClass('heartBeat');
                    },
                    function()
                    {
                        $(this).removeClass('heartBeat');
                    }
                    );
                });
            </script>
        </section>
    </form>
    
    <form id="forgotten-password-form" action="/handlers/send-forgotten-password.php" method="post">
        <?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
        <div class="authorizate-headline forgotten-password-headline">Забытый пароль</div>
        <div class="forgotten-password-content">
            <section class="authorizate-section">
                <div class="authorizate-section-question"><span><?=GetMessage('USER_EMAIL');?>:</span><span class="required"></span></div>
                <div class="authorizate-section-answer">
                    <input type="text" name="USER_EMAIL" class="authorizate-input"/>
                </div>
            </section>
            <p class="forgotten-password-descripttion">
                На адрес электронной почты будет выслан новый пароль.
            </p>
            <section class="authorizate-section">
                <input type="submit" value="Отправить" class="authorizate-submit-button animated" />

                <script type="text/javascript">
                    $(window).ready(function()
                    {
                        var authorizateSubmitButton = $('.authorizate-submit-button');

                        authorizateSubmitButton.hover(
                        function()
                        {
                            $(this).addClass('heartBeat');
                        },
                        function()
                        {
                            $(this).removeClass('heartBeat');
                        }
                        );
                    });
                </script>
            </section>
        </div>
    </form>
</div>

<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH;?>/js/validatorObject.js"></script>

<script type="text/javascript">
    $(window).ready(function()
    {
        var forgottenPasswordHeadline = $('.forgotten-password-headline');
        var forgottenPasswordContent = $('.forgotten-password-content');
        var buttonToggle = false;
        var slideSpeedDuration = 1000;
        
        forgottenPasswordHeadline.on('click', function()
        {
            if(buttonToggle === false)
            {
                forgottenPasswordContent.slideDown(slideSpeedDuration);
                buttonToggle = true;
            }
            else
            {
                forgottenPasswordContent.slideUp(slideSpeedDuration);
                buttonToggle = false;
            }
        });
        
        var authForm = $('form[name=form_auth]');
        
        var validatorObject = new ValidatorObject('.authorizate-section-question', '.required', '.authorizate-input', 
        {
            'USER_LOGIN':
            {
                minStr: 3,
                maxStr: 100
            },
            
            'USER_PASSWORD':
            {
                minStr: 3,
                maxStr: 100
            },
            
            'captcha_word':
            {
                isEmpty: true
            }
        }, 'answer-error');
        
        authForm.on('submit', function()
        {
            var currentForm = $(this);

            currentForm.find('.answer-error').remove();
            
            validatorObject.checkFields();
            
            if(typeof currentForm.find('.answer-error')[0] !== 'undefined'){
                return false;
            }
        });
        
        var forgottenPasswordForm = $('#forgotten-password-form');
        
        validatorObjectToForgottenForm = new ValidatorObject('.authorizate-section-question', '.required', '.authorizate-input', 
        {
            'USER_EMAIL':
            {
                isEmail: true,
                minStr: 3,
                maxStr: 200
            }
        }, 'answer-error');
        
        forgottenPasswordForm.on('submit', function()
        {
            var currentForm = $(this);

            currentForm.find('.answer-error').remove();
            
            validatorObjectToForgottenForm.checkFields();
            
            if(typeof currentForm.find('.answer-error')[0] !== 'undefined'){
                return false;
            }
        });
    });
</script>

<?if(isset($_GET['send_email'])):?>
    <?
    $response = htmlspecialcharsBX($_GET['send_email']);

    if($response == 1):
    ?>
        <p>
            <font class="done-text"><?=GetMessage('EMAIL_SEND');?></font>
        </p>
    <?else:?>
        <p>
            <font class="errortext"><?=GetMessage('EMAIL_UNSEND');?></font>
        </p>
    <?endif;?>
<?elseif(isset($_GET['update_password'])):?>
    <?
    $response = htmlspecialcharsBX($_GET['update_password']);

    if($response == 0):
    ?>
        <p>
            <font class="errortext"><?=GetMessage('PASSWORD_NOT_UPDATE');?></font>
        </p>
    <?endif;?>
<?endif;?>
<?/*default markup
<div class="bx-auth">
<?if($arResult["AUTH_SERVICES"]):?>
	<div class="bx-auth-title"><?echo GetMessage("AUTH_TITLE")?></div>
<?endif?>
	<div class="bx-auth-note"><?=GetMessage("AUTH_PLEASE_AUTH")?></div>

	<form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">

		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
		<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
		<?endif?>
		<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?endforeach?>

		<table class="bx-auth-table">
			<tr>
				<td class="bx-auth-label"><?=GetMessage("AUTH_LOGIN")?></td>
				<td><input class="bx-auth-input form-control" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" /></td>
			</tr>
			<tr>
				<td class="bx-auth-label"><?=GetMessage("AUTH_PASSWORD")?></td>
				<td><input class="bx-auth-input form-control" type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off" />
<?if($arResult["SECURE_AUTH"]):?>
				<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
				<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
				</noscript>
<script type="text/javascript">
document.getElementById('bx_auth_secure').style.display = 'inline-block';
</script>
<?endif?>
				</td>
			</tr>
			<?if($arResult["CAPTCHA_CODE"]):?>
				<tr>
					<td></td>
					<td><input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></td>
				</tr>
				<tr>
					<td class="bx-auth-label"><?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:</td>
					<td><input class="bx-auth-input form-control" type="text" name="captcha_word" maxlength="50" value="" size="15" /></td>
				</tr>
			<?endif;?>
<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
			<tr>
				<td></td>
				<td><input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" /><label for="USER_REMEMBER">&nbsp;<?=GetMessage("AUTH_REMEMBER_ME")?></label></td>
			</tr>
<?endif?>
			<tr>
				<td></td>
				<td class="authorize-submit-cell"><input type="submit" class="btn btn-primary" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" /></td>
			</tr>
		</table>

<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
		<noindex>
			<p>
				<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
			</p>
		</noindex>
<?endif?>

<?if($arParams["NOT_SHOW_LINKS"] != "Y" && $arResult["NEW_USER_REGISTRATION"] == "Y" && $arParams["AUTHORIZE_REGISTRATION"] != "Y"):?>
		<noindex>
			<p>
				<a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a><br />
				<?=GetMessage("AUTH_FIRST_ONE")?>
			</p>
		</noindex>
<?endif?>

	</form>
</div>

<script type="text/javascript">
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>

<?if($arResult["AUTH_SERVICES"]):?>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
	array(
		"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
		"CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
		"AUTH_URL" => $arResult["AUTH_URL"],
		"POST" => $arResult["POST"],
		"SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
		"FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
		"AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
	),
	$component,
	array("HIDE_ICONS"=>"Y")
);
?>
<?endif?>*/?>
