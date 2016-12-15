onready.user.form = {
    signup: function () {
        $("form").validate({
            rules: {
                password: {
                    minlength: 6,
                    password: "[name=username]"
                },
                password_confirm: {
                    minlength: 6,
                    equalTo: "[name=password]"
                },
                username: {
                    remote: {
                        url: "user/ajax/user_exists",
                        type: "post",
                        data: {
                            username: function() {
                                return $("[name=username]").val();
                            },
                            ajax: true
                        }
                    }
                },
                first_name: {
                    minlength: 1,
                    maxlength: 20
                },
                last_name: {
                    minlength: 1,
                    maxlength: 20
                },
                security_question: {
                    maxlength: 100
                }
            },
            messages: {
                password: {
                    minlength: "Passwords must be at least 6 characters"
                },
                password_confirm: {
                    minlength: "Passwords must be at least 6 characters",
                    equalTo: "Your passwords do not match."
                },
                username: {
                    remote: "That username is already taken. Please choose a different username."
                }
            }
        });
    },
    'change_password': function () {
        $("form").validate({
            rules: {
                new_password: {
                    minlength: 6,
                    password: "[name=username]"
                },
                new_password_confirm: {
                    minlength: 6,
                    equalTo: "[name=new_password]"
                }
            },
            messages: {
                new_password: {
                    minlength: "Passwords must be at least 6 characters"
                },
                new_password_confirm: {
                    minlength: "Passwords must be at least 6 characters",
                    equalTo: "Your passwords do not match."
                }
            }
        });
    },
    change_security_data: function () {
        $("form").validate({
            security_question: {
                maxlength: 100
            }
        });
    },
    edit: function () {
        $("form").validate({
            first_name: {
                minlength: 1,
                maxlength: 20
            },
            last_name: {
                minlength: 1,
                maxlength: 20
            }
        });
    }
}
