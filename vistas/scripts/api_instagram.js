
access_token='IGQWRON0o3S2VLa0wtWmk0WnUteEJDMlZAYdW5QaTZAZAd2I5TXhRNjRweWpvZAE9sMHlKQTl1emVvLU9sMGxLMlZA6OUJCTTJzd1RBeW0wVUtYM1hZAeEVycVZAkRXVfSlJSRFJXQktIMkJacVZAQZAkJCSXlrb28xc20zOFEZD';
const url = 'https://graph.instagram.com/3749512751938259?fields=id,username&access_token='+access_token;

fetch (url)
 .then (res=> res.json())
 .then (data => CrearHtml (data. data))

function CraerHtml (data) {
    for (const img of data){
        console.log(img);
    }
}

https://socialsizzle.heroku.com/auth/?
code=AQCsqBUWQ5-sSbxAW7HG_WoKKndTnviV5uRfvdkOpU0E5R-ysTDHv3E-X5qFS1X3500pXqcFJ9M0wkZ57nw35C_SqiUKhhCQRWqStpCB0_yXODwDK732Jsz-Qh3UqTdikkmIjx5xPZpoUfTVG9isdBSrv6_TjpXXq9EACL_xBlGihuUmgfoe_VrU3rRpUaqfI3C6Q6OeRDiOMVP2WCzDLHK4B8N87kk8lMThxtZwVVXVMQ#_

curl - X POST \
https://api.instagram.com/oauth/access_token \
-F client_id = 3749512751938259 \
-F client_secret = 7b24ab7955e1062d3e8e607486bb8a03 \
-F grant_type = authorization_code \
-F redirect_uri = https://socialsizzle.heroku.com/auth/ \
-F code = AQCsqBUWQ5 - sSbxAW7HG_WoKKndTnviV5uRfvdkOpU0E5R - ysTDHv3E - X5qFS1X3500pXqcFJ9M0wkZ57nw35C_SqiUKhhCQRWqStpCB0_yXODwDK732Jsz - Qh3UqTdikkmIjx5xPZpoUfTVG9isdBSrv6_TjpXXq9EACL_xBlGihuUmgfoe_VrU3rRpUaqfI3C6Q6OeRDiOMVP2WCzDLHK4B8N87kk8lMThxtZwVVXVMQ#_

{
    "access_token": "IGQWRPSVpwaW1zaVp6R2Y3SmhOb1BmVTdDamtVZA2FlbmFTUWJsYXlsZAUx4SmZA0eGpTZAnowb0UyaGlLT2t6QVVacHhEZATIxM0UwR2NjUUJPVWpMR2NxN0JKZAVZAuRWhxM2FyMFMxTkJhblJjaHZAjQ2tSbTFLUy15dWdHQlN4dWppN2QydwZDZD",
        "user_id": 6601657979880471
}