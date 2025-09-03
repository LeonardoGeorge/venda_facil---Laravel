package com.seu.pacote.vendafacilapp

import android.Manifest
import android.annotation.SuppressLint
import android.content.pm.PackageManager
import android.os.Build
import android.os.Bundle
import android.webkit.PermissionRequest
import android.webkit.WebChromeClient
import android.webkit.WebSettings
import android.webkit.WebView
import android.webkit.WebViewClient
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.app.ActivityCompat
import androidx.core.content.ContextCompat

class MainActivity : AppCompatActivity() {

    private lateinit var webView: WebView
    private val CAMERA_REQ_CODE = 1001

    private val APP_URL = "https://ab5d2fed7d38.ngrok-free.app" // <-- troque pela sua URL https do ngrok

    @SuppressLint("SetJavaScriptEnabled")
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)

        // Pede permissão de câmera em tempo de execução (Android 6+)
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.CAMERA)
            != PackageManager.PERMISSION_GRANTED
        ) {
            ActivityCompat.requestPermissions(
                this,
                arrayOf(Manifest.permission.CAMERA),
                CAMERA_REQ_CODE
            )
        }

        webView = findViewById(R.id.webview)

        // Configurações do WebView
        with(webView.settings) {
            javaScriptEnabled = true
            domStorageEnabled = true
            databaseEnabled = true
            mediaPlaybackRequiresUserGesture = true
            mixedContentMode = WebSettings.MIXED_CONTENT_ALWAYS_ALLOW // segurança + compat
            // melhora de performance
            cacheMode = WebSettings.LOAD_DEFAULT
            loadsImagesAutomatically = true
            useWideViewPort = true
        }

        // Mantém a navegação dentro do app
        webView.webViewClient = object : WebViewClient() {}

        // Libera permissões WebRTC (câmera) solicitadas pela página (Quagga/getUserMedia)
        webView.webChromeClient = object : WebChromeClient() {
            override fun onPermissionRequest(request: PermissionRequest?) {
                runOnUiThread {
                    if (request == null) return@runOnUiThread
                    // Concede as permissões pedidas pela página (video/audio se necessário)
                    request.grant(request.resources)
                }
            }
        }

        // Carrega sua aplicação Laravel
        webView.loadUrl(APP_URL)
    }

    // Botão "voltar" navega no histórico do WebView
    override fun onBackPressed() {
        if (::webView.isInitialized && webView.canGoBack()) {
            webView.goBack()
        } else {
            super.onBackPressed()
        }
    }
}
