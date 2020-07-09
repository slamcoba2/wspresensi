$.validator.addMethod(
        "DateFormat",
        function(value, element) {
            return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
        },
        "Please enter a date in the format dd-mm-yyyy"//removed ;
        );