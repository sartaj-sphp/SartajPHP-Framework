plugins {
    id("com.android.application")
    id("org.jetbrains.kotlin.android")
	##{$caller->renderAndroidSettings("plugins")}#
}

android {
    namespace = "##{$caller->mobappid}#"
    compileSdk = ##{$caller->compileSdkVersion}#

    sourceSets {
        getByName("main") {
            jniLibs.srcDirs("libs")
        }
    }

    defaultConfig {
        applicationId = "##{$caller->mobappid}#"
        minSdk = ##{$caller->minSdkVersion}#
        targetSdk = ##{$caller->targetSdkVersion}#
        versionCode = 1
        versionName = "##{$caller->mobappversion}#"

        testInstrumentationRunner = "androidx.test.runner.AndroidJUnitRunner"
        vectorDrawables {
            useSupportLibrary = true
        }
    }

    buildTypes {
        release {
            isMinifyEnabled = false
            proguardFiles(
                getDefaultProguardFile("proguard-android-optimize.txt"),
                "proguard-rules.pro"
            )
        }
    }
    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_1_8
        targetCompatibility = JavaVersion.VERSION_1_8
    }
    kotlinOptions {
        jvmTarget = "1.8"
    }
    buildFeatures {
        compose = true
    }
    composeOptions {
        kotlinCompilerExtensionVersion = "1.5.1"
    }
    packaging {
        resources {
            excludes += "/META-INF/{AL2.0,LGPL2.1}"
        }
        jniLibs {
            useLegacyPackaging = true
        }
    }
    
    buildToolsVersion = "34.0.0"
	
    ##{raw:$caller->renderAndroidSettings("android")}#
	
}

dependencies {

    implementation("androidx.core:core-ktx:1.10.0")
    implementation("androidx.lifecycle:lifecycle-runtime-ktx:2.8.7")
    implementation("androidx.activity:activity-compose:1.9.3")
    implementation(platform("androidx.compose:compose-bom:2024.12.01"))
    implementation("androidx.compose.ui:ui")
    implementation("androidx.compose.ui:ui-graphics")
    implementation("androidx.compose.ui:ui-tooling-preview")
    implementation("androidx.compose.material3:material3")
    implementation("org.jetbrains.kotlin:kotlin-reflect")
    implementation(files("libs/webviewlib-release.aar"))
    implementation(fileTree(mapOf(
        "dir" to "libs",
        "include" to listOf("*.jar")
    )))

  ##{raw:$caller->renderAndroidSettings("dependency")}#
	
    testImplementation("junit:junit:4.13.2")
    androidTestImplementation("androidx.test.ext:junit:1.2.1")
    androidTestImplementation("androidx.test.espresso:espresso-core:3.6.1")
    androidTestImplementation(platform("androidx.compose:compose-bom:2024.12.01"))
    androidTestImplementation("androidx.compose.ui:ui-test-junit4")
    debugImplementation("androidx.compose.ui:ui-tooling")
    debugImplementation("androidx.compose.ui:ui-test-manifest")
}