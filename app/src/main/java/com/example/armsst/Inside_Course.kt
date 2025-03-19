package com.example.armsst

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView

class Inside_Course : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.inside_course)

        val recyclerStudyMaterial = findViewById<RecyclerView>(R.id.studyMaterialsRecyclerView)
        val recyclerMessages = findViewById<RecyclerView>(R.id.messagesRecyclerView)

        val studyMaterials = listOf(
            StudyMaterial("Kotlin Basics", "https://kotlinlang.org/docs/basic-syntax.html"),
            StudyMaterial("Android RecyclerView", "https://developer.android.com/guide/topics/ui/layout/recyclerview")
        )

        val messages = listOf(
            Message("Dr. Smith", "Submit your assignments by Monday."),
            Message("Prof. Brown", "Midterm exams start next week. Prepare well!")
        )

        recyclerStudyMaterial.layoutManager = LinearLayoutManager(this)
        recyclerStudyMaterial.adapter = StudyMaterialAdapter(studyMaterials)

        recyclerMessages.layoutManager = LinearLayoutManager(this)
        recyclerMessages.adapter = MessageAdapter(messages)
    }
}
