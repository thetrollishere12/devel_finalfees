<?php
    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com

    $production         = true;   // toggle to true if going against production
    $debug              = false;   // toggle to provide debugging info
    $compatabilityLevel = 681;    // eBay API version
    $findingVer = "1.8.0"; //eBay Finding API version

    //SiteID must also be set in the request
    //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
    //SiteID Indicates the eBay site to associate the call with
    $siteID = 0;

    if ($production) {
        $devID = '86f76ae6-e8eb-4e46-a383-1340fcaa49e1';   // these prod keys are different from sandbox keys
        $appID = 'Finalfee-Finalfee-PRD-3d8c7c7a2-cb66ef44';
        $certID = 'PRD-d8c7c7a29149-4570-4f7a-a9c3-4df2';
        //set the Server to use (Sandbox or Production)
        $serverUrl   = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        $shoppingURL = 'http://open.api.ebay.com/shopping';
        $findingURL= 'http://svcs.ebay.com/services/search/FindingService/v1';
$loginURL = 'https://signin.ebay.com/ws/eBayISAPI.dll'; // This is the URL to start the Auth & Auth process
        $feedbackURL = 'http://feedback.ebay.com/ws/eBayISAPI.dll'; // This is used to for link to feedback
         $runame = 'Finalfees-Finalfee-Finalf-anafnt';  // sandbox runame

        // This is used in the Auth and Auth flow

        // This is an initial token, not to be confused with the token that is fetched by the FetchToken call
        $appToken = 'AgAAAA**AQAAAA**aAAAAA**lzgwXQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AMk4unCJSLogidj6x9nY+seQ**aw4GAA**AAMAAA**GtT5uOiH3pYHPXsyKWJSqAR4rEgojKnFcJMypgAcR60l8MAatu1IZ9lCY08DWGW6F2NLilmjigyIo5zMWV+3divrZs4/9Kh2wioBKSQOhfyFznfatypsSVC1o3Ky0XQSeyWPuDYhNefVoDvF4vzPBOj1yVCVIusI3nXt64vYYZoEVWCJFjt8vYcKv9BcEsRgeWs78lAIPWzgrhhK/dtLUrMhlw9UFXpIpFbxfHb3fC1ARjdvqg4kNf0yMCfRXMPEown88hjHiWPnfTQBOG7KUDcqc4KJqZyX8WY5V2uVAW/JWC4RCoM+YVbE/YVscqymq15dBhm392Ec8bpz9U5QwNfa7z9EanbdF+cbowESf0I7NZci0Iwdewg2vodlcW5pWfYAojRhoI8r0o5DoJ/dYB5odsjAPrbRA4peHx9sEr4aNirJxaE2EAFRchMdP5S9EXsEjGsxXWZeQRI0d3+Yf4Fd9QNgD8tGFBYjHdIkRajs24FnWIkiLMAir5+2wDYgFrts707JWY2/Xbr/BIHH6pG4EkJR45pV8zRaG7pCJI2c8IeJkutXRzD3IjvYvk9UMHEdBb/yQNexkBEVHirGMRxozbzd0WLz59ltoCqMVw/+4DKeFbmRqzYq24/O9I4jakqoZsl/Qft6for9ZlDxBBzz0msa5JxTmfqmZeJ8ZttTqT9OFiDY6VIclJ6ICfR+vZYTV9YGNUW6JvCuZEqMIwmgYvhfkTYzZqiRJf7eOwSutn3KTegj+fxM+IRxDOOz';
    } else {
        // sandbox (test) environment
        $devID  = '86f76ae6-e8eb-4e46-a383-1340fcaa49e1';   // insert your devID for sandbox
        $appID  = 'Finalfee-Finalfee-SBX-1d8cefab8-e7e90dbb';   // different from prod keys
        $certID = 'SBX-d8cefab8718c-4a3c-4479-b4d9-df1c';   // need three keys and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        $shoppingURL = 'http://open.api.sandbox.ebay.com/shopping';
        $findingURL= 'http://svcs.sandbox.ebay.com/services/search/FindingService/v1';


        $loginURL = 'https://signin.sandbox.ebay.com/ws/eBayISAPI.dll'; // This is the URL to start the Auth & Auth process
        $feedbackURL = 'http://feedback.sandbox.ebay.com/ws/eBayISAPI.dll'; // This is used to for link to feedback

        $runame = 'testuser_finalfees';  // sandbox runame

        // This is the sandbox application token, not to be confused with the sandbox user token that is fetched.
        // This token is a long string - do not insert new lines.
        $appToken = 'AgAAAA**AQAAAA**aAAAAA**d2csXQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4aiCZaDpgydj6x9nY+seQ**uQkFAA**AAMAAA**cKpwq9WxNeQZ/YXWQ1A3ppx4vZr2VnIVxrCIx8YiI+wGO+T9rxQYqPaq3x9P8aQ76H+3mtFgzZqG39e8GOk9NS7c3tSi1TGnWiOYE+sG0j5bIp4cUwg6IcUGwNdgpFuCAOeOSYGWkdxpKTNNVDVoh9ty4bgR3AqItj3xEecVaK2KugIuPH/k+ij2Y4tbp/EAmhXQ/6Q4BtBR3ctrvbdzRpZWDMLhJVLoLAFeoTfIxmGQarwNU75Hg+g5TQWv/KrHr/xAAVQWfp7H7elaTGEIiPMRVCnE3Mwz8F350wm5WH3qtIs3IKj283KwdhYGj2QDyIcYu51zyTBxX8GICO2I+u8BpRtWvFtR+AsJ09XGKsQqM3zvihhAgWe89xGPZYbvrsbDjmHJu5LKPej1wjcP949mb/PR3tZsHYNTmEH2pmQMdIypEk7GcC9XY9+o+TnylgcIPuZYiaNqNBhMIkr4D06OiMo4Hv4XwuREFiEaSDngDu6+MajjvmFmsCLqy2/YLlKYpkbmFlY3nwnulLIQ0fFdTLvVwlliQAbWMc8ob6zCG57J8NhXRGPCPUExHu7mu5/H3Png7GnC8tl5yZ8dJ9c9XfplgNmT4zz4/wBdm89pBxnAzVUQb9NYhrtgeeHF1JpodkyQZFCHy+uo12LGxmPa+fh0w4BSp8uYeFmCZuHxoi1hxaXJW6Fh0KgcVeyeQ5iTAMwq83Ejn0CwRhNlQhr17uPRN2O67vXMST+4yF1FjvPQzYxdQx6V1Z7Oarje';
    }


?>