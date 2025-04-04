<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MetaMask Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/5.2.0/ethers.umd.min.js" type="application/javascript"></script>

    <script>
        async function web3Login() {
            if (!window.ethereum) {
                alert('MetaMask not detected. Please install MetaMask first.');
                return;
            }

            const provider = new ethers.providers.Web3Provider(window.ethereum);

            let response = await fetch('/web3-login-message');
            const message = await response.text();

            await provider.send("eth_requestAccounts", []);
            const address = await provider.getSigner().getAddress();
            const signature = await provider.getSigner().signMessage(message);

            response = await fetch('/web3-login-verify', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'address': address,
                    'signature': signature,
                    '_token': '{{ csrf_token() }}'
                })
            });
            const data = await response.text();

            console.log("data", data);
            console.log("address", address);
            console.log("signature", signature);

            if (data === "OK") {
                alert("Success message")
            } else {
                alert("Error message");
            }
        }
    </script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-primary mt-5" onclick="web3Login();">Log in with MetaMask</button>
        </div>
    </div>
</div>
</body>
</html>
