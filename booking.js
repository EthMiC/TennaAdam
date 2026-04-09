document.getElementsByName("select_patient").forEach((element) => {
    element.addEventListener("change", (e) => {
        switch (e.target.selectedOptions[0].innerText) {
            case ("My Self"):
                document.getElementById("self_form").hidden = false;
                [...document.getElementById("self_form").children].forEach((element) => {
                    element.required = true;
                })
                document.getElementById("other_form").hidden = true;
                [...document.getElementById("other_form").children].forEach((element) => {
                    element.required = false;
                })
                break;
            case ("Family or Friend"):
                document.getElementById("self_form").hidden = true;
                [...document.getElementById("self_form").children].forEach((element) => {
                    element.required = false;
                })
                document.getElementById("other_form").hidden = false;
                [...document.getElementById("other_form").children].forEach((element) => {
                    element.required = true;
                    console.log(element);
                })
                break;
            default:
                document.getElementById("self_form").hidden = true;
                [...document.getElementById("self_form").children].forEach((element) => {
                    element.required = false;
                })
                document.getElementById("other_form").hidden = true;
                [...document.getElementById("other_form").children].forEach((element) => {
                    element.required = false;
                })
                break;
                
        }
    })
});

document.querySelector("form")
    .addEventListener("submit", (e) => {
        e.preventDefault();
        let form = e.target;
        let message = {
            "title": form[0].value,
            "full_name": form[1].value,
            "phone_number": Number(form[2].value),
            "email": form[3].value,
            "recipient": form[4].value,
            "self_reason": form[5].value,
            "other_recipient_name": form[6].value,
            "other_recipient_reason": form[7].value,
        };

        console.log(message);

        fetch("./submission.php", {
            "method": "POST",
            "headers": {
                "Content-Type": "application/x-www-form-urlencoded; charset=utf-8"
            },
            "body": new URLSearchParams(message),
        })
        .then((res) => {
            console.log(res.text())
            if (String(res.status)[0] == 2) {
                return res;
            }
            else {
                throw res;
            }
        })
        .then((res) => {
            // window.location.replace("/confirm");
        })
        .catch((res) => {
            switch (String(res.status)[0]) {
                case '4':
                    alert("Request Timesout! Please try again shortly.");
                    break;
                case '5':
                    alert("Server Error! Please try again shortly.");
                    break;
                default:
                    alert("Unknown Error! Please try again shortly.");
            }
        })
    });