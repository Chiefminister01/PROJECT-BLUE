package com.example.armsst

import android.os.Bundle
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity

class StudentToDo {
    class StudentToDot: AppCompatActivity() {
        override fun onCreate(savedInstanceState: Bundle?)
        {
            super.onCreate(savedInstanceState)
            enableEdgeToEdge()
            setContentView(R.layout.student_todo)
        }
    }
}