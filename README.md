# Virtual Queue Token Verifier SDK

SDK para verificar tokens de colas virtuales.

## Instalación

```bash
composer require virtual-queue/token-verifier
```

## Uso básico

```php
<?php

require_once 'vendor/autoload.php';

use VirtualQueue\TokenVerifier\TokenVerifier;
use VirtualQueue\TokenVerifier\Exception\ApiException;

// Inicializar el verificador de tokens
$verifier = new TokenVerifier();

// Obtener el token de la URL
$token = $_GET['token'] ?? null;

try {
    // Verificar el token
    $tokenData = $verifier->verifyToken($token);
    
    // El token es válido, continuar con la lógica de la aplicación
    // Por ejemplo, mostrar un formulario de compra
    echo "Token válido. Bienvenido a nuestro sitio.";
    
} catch (ApiException $e) {
    // Error de la API
    echo "Error: " . $e->getMessage();
    
    if ($e->getErrorCode() === 404) {
        echo "Token no válido o expirado.";
    }
} catch (Exception $e) {
    // Otros errores
    echo "Error: " . $e->getMessage();
}
```

## Métodos disponibles

### verifyToken(string $token): array

Verifica un token y devuelve los datos asociados si es válido.

### isTokenValid(string $token): bool

Comprueba si un token es válido (devuelve true o false).

### getFinishedLineDetails(string $token): ?array

Obtiene los detalles de finalización de cola para un token válido.

## Manejo de errores

```php
try {
    $tokenData = $verifier->verifyToken($token);
} catch (VirtualQueue\TokenVerifier\Exception\ApiException $e) {
    // Error de la API (por ejemplo, token no válido)
    echo "Error de API: " . $e->getMessage();
    echo "Código de error: " . $e->getErrorCode();
} catch (VirtualQueue\TokenVerifier\Exception\NetworkException $e) {
    // Error de red
    echo "Error de red: " . $e->getMessage();
} catch (VirtualQueue\TokenVerifier\Exception\SdkException $e) {
    // Otros errores del SDK
    echo "Error del SDK: " . $e->getMessage();
}
```

## Licencia

MIT