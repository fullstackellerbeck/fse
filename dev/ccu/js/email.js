function sendMail( recipient, emailSubject, fullName, eMail, category ) {
    var appKey = 'Yzc3YWI1MDAtNzdkZS00NGY2LWE2Y2YtYzRmMzUxNjJlOWRk';
    var apiUrl = "http://uatapi.adflowdms.net";
    // Route is in the format of "template/{templateKey}/send". 
    var apiRoute = "v1.0/template/MJEWAUR0C/send/each";
    var requestUrl = apiUrl + "/" + apiRoute;

    // The data that will be sent to the API in the request body.
    var request = [
        {
            recipientAddress: recipient, // "bhowley@adflownetworks.com",
            subject: emailSubject, //"API Test (bhowley@adflownetworks.com)",
            parameters: {
				customerName: fullName, //"John Doe",
				customerEmail: eMail, // "john@doe.com",
                categories: category //[ "Savings Accounts", "Investments", "Mortgages" ]
            }
        }
    ];

    // Convert the request body into a JSON string before sending.
    var sRequest = JSON.stringify(request, null, 2);

    // Submit the request to the API.
    $.ajax({
        type: "POST",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', appKey);
        },
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: requestUrl,
        data: sRequest,
        async: false,
        success: function(response) {
            var result = response.data;
            // Show the result in the browser.
            $('#apiResult').html(result);
            var sResponse = JSON.stringify(response, null, 2);
            $('#apiResponse').html('<pre>' + sResponse + '</pre>');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Request failed. Use the debug tools of your browser for more information.");
        }
    });
}
