<?php

    $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions";
    
    $email = "pavideo@inacsistemas.com";
    $token = "9CC95B4C4674471588DA7D40CD40F2F2";

	$credenciais = array(
	    	"email" => $email,
			"token" => $token
	);
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($credenciais));
	$resultado = curl_exec($curl);
	curl_close($curl);
    $session = simplexml_load_string($resultado)->id;
    
    if(isset($_POST["checkoutValue"])){

        $creditCardToken = $_POST["creditCardToken"];
        $senderHash = $_POST["senderHash"];
        $installmentComboFilter = filter_input(INPUT_POST, 'InstallmentCombo', FILTER_SANITIZE_SPECIAL_CHARS);
        $arrInstallmentCombo = explode("-", $installmentComboFilter);
        $installmentCombo = $arrInstallmentCombo[0];
        $installmentValue = $arrInstallmentCombo[1];

        // echo "**".$installmentCombo."**";
        // echo "**".$installmentValue."**";

        $data["email"] = $email;
        $data["token"] = $token;
        $data["paymentMode"] = "default";
        $data["paymentMethod"] = "creditCard";
        $data["receiverEmail"] = $email;
        $data["currency"] = "BRL";
        // $data["extraAmount"] = "1.00";
        $data["extraAmount"] = "-1.00";
        $data["itemId1"] = "0001";
        $data["itemDescription1"] = "Notebook Prata";
        $data["itemAmount1"] = "500.00";
        $data["itemQuantity1"] = "1";
        $data["notificationURL"] = "https://sualoja.com.br/notifica.html";
        $data["reference"] = "REF1234";
        $data["senderName"] = "José Comprador";
        $data["senderCPF"] = "22111944785";
        $data["senderAreaCode"] = "11";
        $data["senderPhone"] = "56273440";
        $data["senderEmail"] = "c06300302336004177869@sandbox.pagseguro.com.br";
        $data["senderHash"] = $senderHash;
        $data["shippingAddressRequired"] = "true";
        $data["shippingAddressStreet"] = "Av. Brig. Faria Lima";
        $data["shippingAddressNumber"] = "1384";
        $data["shippingAddressComplement"] = "5o andar";
        $data["shippingAddressDistrict"] = "Jardim Paulistano";
        $data["shippingAddressPostalCode"] = "01452002";
        $data["shippingAddressCity"] = "Sao Paulo";
        $data["shippingAddressState"] = "SP";
        $data["shippingAddressCountry"] = "BRA";
        $data["shippingType"] = "1";
        $data["shippingCost"] = "0.00";
        $data["creditCardToken"] = $creditCardToken;
        $data["installmentQuantity"] = $installmentCombo;
        $data["installmentValue"] = $installmentValue;
        $data["noInterestInstallmentQuantity"] = 2;
        $data["creditCardHolderName"] = "Jose Comprador";
        $data["creditCardHolderCPF"] = "22111944785";
        $data["creditCardHolderBirthDate"] = "27/10/1987";
        $data["creditCardHolderAreaCode"] = "11";
        $data["creditCardHolderPhone"] = "56273440";
        $data["billingAddressStreet"] = "Av. Brig. Faria Lima";
        $data["billingAddressNumber"] = "1384";
        $data["billingAddressComplement"] = "5o andar";
        $data["billingAddressDistrict"] = "Jardim Paulistano";
        $data["billingAddressPostalCode"] = "01452002";
        $data["billingAddressCity"] = "Sao Paulo";
        $data["billingAddressState"] = "SP";
        $data["billingAddressCountry"] = "BRA";

        $build_query = http_build_query($data);
        $url_new = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions";

        $curl_new = curl_init($url_new);
        curl_setopt($curl_new, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($curl_new, CURLOPT_POST, true);
        curl_setopt($curl_new, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_new, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_new, CURLOPT_POSTFIELDS, $build_query);
        $retorno = curl_exec($curl_new);
        curl_close($curl_new);

        $result = simplexml_load_string($retorno);
        var_dump(json_encode($result));
    }
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
	<title>Checkout Transparente PagSeguro</title>
    <style>
        #InstallmentCombo{
            display: none;
        }
    </style>
</head>
<body>
	<div class="text-center">
	<h1 class = "text-center">CHECKOUT TRANSPARENTE DEMO - PAGSEGURO [SANDBOX]</h1><hr>
	</div>

    <form method="post" action="">
	 
	<input type="hidden" id="senderHash" name="senderHash">

	<fieldset>
	<legend class="text-center">CHAMADAS PARA CARTÃO DE CRÉDITO</legend>


	<div class="row mx-md-n5">
  	<div class="col px-md-5"><div class="p-3 border bg-light">
	<div class="row">
		<div class="col-sm-4"> 
		<div>
		<label for="senderName"><b>Nome:</b></label> 
		<input type="text" class="form-control" id="senderName" class="creditcard" name="senderName" required>
		</div>
		<div>
		<label for="creditCardNumber"><b>Número do cartão:</b></label> 
		<input type="text" class="form-control" id="creditCardNumber" class="creditcard" name="creditCardNumber" required>
		</div>
		<div>
		<label for="creditCardBrand"><b>Bandeira:</b></label>
		<input type="text" class="form-control" id="creditCardBrand" class="creditcard" name="creditCardBrand" disabled>
		</div></div>
		<div class="col-sm-4">
		<label for="creditCardExpMonth"><b>Validade Mês (mm):</b></label>
		<input type="text" class="form-control" id="creditCardExpMonth" class="creditcard" name="creditCardExpMonth" size="2" required> &nbsp;

		 
		<label for="creditCardExpYear"><b>Ano (yyyy):</b></label>
		<input type="text" class="form-control" id="creditCardExpYear" class="creditcard" name="creditCardExpYear" size="4" required>
		</div>

		<div class="col-sm-4">
		<label for="creditCardCvv"><b>CVV:</b></label>
		<input type="text" class="form-control" id="creditCardCvv" class="creditcard" name="creditCardCvv" required>
	
		<input type="hidden" id="creditCardToken" name="creditCardToken">	
	
	</div>
	</div>
	</div></div>

	</fieldset>
	<br>
	<fieldset>
	<legend class="text-center">PARCELAMENTO</legend>
	<div class="row mx-md-n5">
  	<div class="col px-md-5"><div class="p-3 border bg-light">
	Valor do Checkout: <input class="form-control" type="text" id="checkoutValue" name="checkoutValue" required>
	</p>
	<p>
	<select id="InstallmentCombo" name="InstallmentCombo">
	</select>
	</p>
	</div>
	</div>
	</fieldset>

    <p><input type="submit" value="Enviar"></p>

    </form>
	
</body>
<!-- Incluíndo o arquivo JS do PagSeguro e o JQuery-->
<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Funcionalidade do JS -->
<script type="text/javascript">

	//Session ID
	PagSeguroDirectPayment.setSessionId('<?php echo $session; ?>');
	// console.log('<?php //echo $session; ?>');

	//Get SenderHash
    PagSeguroDirectPayment.onSenderHashReady(function(response){
        if(response.status == 'error') {
            // console.log(response.message);
            return false;
        }
        //Hash estará disponível nesta variável.
        $("#senderHash").val(response.senderHash);	
    });

	//Get CreditCard Brand and check if is Internationl
	$("#creditCardNumber").keyup(function(){
		if ($("#creditCardNumber").val().length >= 6) {
			PagSeguroDirectPayment.getBrand({
				cardBin: $("#creditCardNumber").val().substring(0,6),
				success: function(response) { 
						// console.log(response);
						$("#creditCardBrand").val(response['brand']['name']);
						$("#creditCardCvv").attr('size', response['brand']['cvvSize']);
				},
				error: function(response) {
					// console.log(response);
				}
			})
		};
	})

	function printError(error){
		$.each(error['errors'], (function(key, value){
			// console.log("Foi retornado o código " + key + " com a mensagem: " + value);
		}));
	}

	function getPaymentMethods(valor){
		PagSeguroDirectPayment.getPaymentMethods({
			amount: valor,
			success: function(response) {
				// console.log(JSON.stringify(response));
				// console.log(response);
			},
			error: function(response) {
				// console.log(JSON.stringify(response));
			}
		})
	}

	//Generates the creditCardToken
	$("#creditCardCvv").keyup(function(){
		var param = {
			cardNumber: $("#creditCardNumber").val(),
			cvv: $("#creditCardCvv").val(),
			expirationMonth: $("#creditCardExpMonth").val(),
            expirationYear: $("#creditCardExpYear").val(),
            

            // cardNumber: '4111111111111111',
            // brand: 'visa',
            // cvv: '123',
            // expirationMonth: '12',
            // expirationYear: '2030',


			success: function(response) {
				// console.log(response);
				$("#creditCardToken").val(response['card']['token']);
			},
			error: function(response) {
				// console.log(response);
				printError(response);
			}
		}
        //parâmetro opcional para qualquer chamada
        if($("#creditCardBrand").val() != '') {
            param.brand = $("#creditCardBrand").val();
        }
        PagSeguroDirectPayment.createCardToken(param);
    })  

	//Check installment
    $("#checkoutValue").change(function(){
		if($("#creditCardBrand").val() != '') {
            $("#InstallmentCombo").fadeIn();
            getInstallments();
		} else {
			alert("Uma bandeira deve estar selecionada");
		}
    })

	function getInstallments(){
		var brand = $("#creditCardBrand").val();
		PagSeguroDirectPayment.getInstallments({
			amount: $("#checkoutValue").val().replace(",", "."),
			brand: brand,
			maxInstallmentNoInterest: 2, //calculo de parcelas sem juros
			success: function(response) {
				var installments = response['installments'][brand];
                buildInstallmentSelect(installments);
                

			},
			error: function(response) {
				// console.log(response);
			}
		})
    }
    
    var checkoutVal = 0;

	function buildInstallmentSelect(installments){
		$.each(installments, (function(key, value){
            if(checkoutVal != $("#checkoutValue").val()){
                $("#InstallmentCombo").html("<option value = "+ value['quantity'] + "-" + value['installmentAmount'].toFixed(2) + "-" + value['totalAmount'].toFixed(2) + ">" + value['quantity'] + "x de " + value['installmentAmount'].toFixed(2) + " - Total de " + value['totalAmount'].toFixed(2)+"</option>");
                checkoutVal = $("#checkoutValue").val();
            }else{
                $("#InstallmentCombo").append("<option value = "+ value['quantity'] + "-" + value['installmentAmount'].toFixed(2) + "-" + value['totalAmount'].toFixed(2) + ">" + value['quantity'] + "x de " + value['installmentAmount'].toFixed(2) + " - Total de " + value['totalAmount'].toFixed(2)+"</option>");     
            }
            
		}))
	}
</script>

</html>
