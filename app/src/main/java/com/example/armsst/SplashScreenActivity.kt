package com.example.armsst

import android.content.Intent
import android.os.Bundle
import android.widget.Button
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import com.example.armsst.databinding.ActivitySplashScreenBinding

class SplashScreenActivity : AppCompatActivity() {

    lateinit var binding: ActivitySplashScreenBinding


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        binding = ActivitySplashScreenBinding.inflate(layoutInflater)

        setContentView(binding.root)
        enableEdgeToEdge()

        binding.teacherButton.setOnClickListener {
            startActivity(Intent(this@SplashScreenActivity,TeacherLoginActivity::class.java))

        }

        binding.studentButton.setOnClickListener {
            startActivity(Intent(this@SplashScreenActivity,StudentLoginActivity::class.java))
        }
        binding.teacherButton.setOnClickListener {
            startActivity(Intent(this@SplashScreenActivity,TeacherLoginActivity::class.java))
        }
        binding.adminButton.setOnClickListener {
            startActivity(Intent(this@SplashScreenActivity,AdminLoginActivity::class.java))
        }


    }
}