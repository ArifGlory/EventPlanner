<script src="{{ asset('/frontend/js/jquery-3.6.1.min.js')}}"></script>
<script src="{{ asset('/frontend/js/plugins.js')}}"></script>
<script src="{{ asset('/frontend/js/theme.js')}}"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@1.5.7/dist/lottie-player.js"></script>
<script src="https://cdn.ethers.io/lib/ethers-5.2.umd.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

    });
    async function web3Login() {
        if (!window.ethereum) {
            alert('MetaMask not detected. Please install MetaMask first.');
            return;
        }

        const provider = new ethers.providers.Web3Provider(window.ethereum);
        var urlMessage = '{{route('web3.message')}}';
        var verifyMessage = '{{route('web3.verify')}}';

        let response = await fetch(urlMessage);
        const message = await response.text();

        await provider.send("eth_requestAccounts", []);
        const address = await provider.getSigner().getAddress();
        const signature = await provider.getSigner().signMessage(message);

        response = await fetch(verifyMessage, {
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

        console.log(data);

    }
</script>
