<?php
require "../config/Conexion.php";

class Modelo
{
    private $tenantId;
    private $clientId;
    private $clientSecret;
    private $scope;
    private $groupId;
    private $reportId;

    public function __construct()
    {
        // ⚠️ Ideal: mover a variables de entorno o a un archivo seguro no versionado.
        $this->tenantId     = "1a668a99-bb75-4376-817c-5768f5161e43";
        $this->clientId     = "86e96a79-6581-4ee5-9878-ea42c9f8bd81";
        $this->clientSecret = "wff8Q~1Jv_gjFlZVM2JT-RnMVc77CFBMZxoz-b32";
        $this->scope        = "https://analysis.windows.net/powerbi/api/.default";
        $this->groupId      = "a4daadc4-4173-43f3-8e25-29b4b921d401";
        $this->reportId     = "3d7deb4a-d308-489c-984f-2ef9ba8f1b92";
    }

    public function obtenerEmbedConfig(): array
    {
        $accessToken = $this->obtenerAccessToken();
        if (!$accessToken) {
            throw new Exception("No se pudo obtener el access token.");
        }

        $embedUrl = $this->obtenerEmbedUrl($accessToken);
        if (!$embedUrl) {
            throw new Exception("No se pudo obtener el embedUrl.");
        }

        $embedToken = $this->generarEmbedToken($accessToken);
        if (!$embedToken) {
            throw new Exception("No se pudo generar el embed token.");
        }

        return [
            "embedUrl"   => $embedUrl,
            "embedToken" => $embedToken,
            "reportId"   => $this->reportId
        ];
    }

    // ===== Helpers específicos Power BI / Azure AD =====
    private function obtenerAccessToken(): ?string
    {
        $url  = "https://login.microsoftonline.com/{$this->tenantId}/oauth2/v2.0/token";
        $data = [
            "grant_type"    => "client_credentials",
            "client_id"     => $this->clientId,
            "client_secret" => $this->clientSecret,
            "scope"         => $this->scope
        ];
        $res = $this->httpPostForm($url, $data);
        return $res["access_token"] ?? null;
    }

    private function obtenerEmbedUrl(string $accessToken): ?string
    {
        $url = "https://api.powerbi.com/v1.0/myorg/groups/{$this->groupId}/reports/{$this->reportId}";
        $res = $this->httpGetJson($url, $accessToken);
        return $res["embedUrl"] ?? null;
    }

    private function generarEmbedToken(string $accessToken): ?string
    {
        $url  = "https://api.powerbi.com/v1.0/myorg/groups/{$this->groupId}/reports/{$this->reportId}/GenerateToken";
        $body = ["accessLevel" => "View"];
        $res  = $this->httpPostJson($url, $body, $accessToken);
        return $res["token"] ?? null;
    }

    // ===== Helpers HTTP con cURL =====
    private function httpPostForm(string $url, array $data): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ["Content-Type: application/x-www-form-urlencoded"],
        ]);
        $resp = curl_exec($ch);
        if ($resp === false) throw new Exception("HTTP POST FORM error: " . curl_error($ch));
        curl_close($ch);
        return json_decode($resp, true) ?? [];
    }

    private function httpPostJson(string $url, array $data, string $bearer): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/json",
                "Authorization: Bearer $bearer"
            ],
        ]);
        $resp = curl_exec($ch);
        if ($resp === false) throw new Exception("HTTP POST JSON error: " . curl_error($ch));
        curl_close($ch);
        return json_decode($resp, true) ?? [];
    }

    private function httpGetJson(string $url, string $bearer): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPGET        => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => ["Authorization: Bearer $bearer"],
        ]);
        $resp = curl_exec($ch);
        if ($resp === false) throw new Exception("HTTP GET error: " . curl_error($ch));
        curl_close($ch);
        return json_decode($resp, true) ?? [];
    }
}
