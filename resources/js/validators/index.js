import VValidate from "vee-validate";

VValidate.Validator.extend("verify_password", {
    getMessage: field =>
        `The password must contain at least: 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character`,
    validate: value => {
        var strongRegex = new RegExp(
            "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*?+-.,:;_=])(?=.{8,})"
        );
        return strongRegex.test(value);
    }
});
VValidate.Validator.extend("verify_name", {
    getMessage: field =>
        `The ${field} may only contain alphabetic characters as well as spaces or apostrophe`,
    validate: value => {
        var strongRegex = new RegExp("^[A-Za-z' ]*$");
        return strongRegex.test(value);
    }
});
