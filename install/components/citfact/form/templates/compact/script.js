'use strict';

/**
 * Construct object
 *
 * @param object params
 * @constructor
 */
var FormGenerator = function (params) {
    this.form = params.formContainer;
    this.ajaxMode = params.ajaxMode;
    this.captchaImg = params.captchaImg;
    this.captchaReload = params.captchaReload;
    this.uri = params.uri;
}

/**
 * Init events
 */
FormGenerator.prototype.init = function () {
    this.reloadCaptcha();
    if (this.ajaxMode) {
        this.submitForm();
    }
}

/**
 * Event submit form when ajaxMode = true
 */
FormGenerator.prototype.submitForm = function () {
    var self = this;
    $(document).on('submit', this.form, function () {
        $.post(self.uri, $(self.form).serialize(), function (response) {
            $(self.form).replaceWith(response.html);
            self.reloadCaptcha();
        });

        return false;
    });
}

/**
 * Event reload captcha
 */
FormGenerator.prototype.reloadCaptcha = function () {
    var self = this;
    $(this.form).on('click', this.captchaReload, function () {
        $.post(self.uri, $(self.form).serialize(), function (response) {
            self.setCaptcha(response.captcha);
        });

        return false;
    });
}

/**
 * Set new captcha
 *
 * @param string code
 */
FormGenerator.prototype.setCaptcha = function (code) {
    $(this.form).find('input[name*=captcha_sid]').val(code);
    $(this.form).find(this.captchaImg).prop('src', '/bitrix/tools/captcha.php?captcha_sid=' + code);
}