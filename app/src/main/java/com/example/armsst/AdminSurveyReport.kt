package com.example.armsst

import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.armsst.com.example.armsst.Survey

class AdminSurveyReport : AppCompatActivity() {

    private lateinit var recyclerView: RecyclerView
    private lateinit var surveyAdapter: SurveyAdapter
    private lateinit var surveyList: ArrayList<Survey>

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.admin_survey_report)

        recyclerView = findViewById(R.id.recyclerView)
        recyclerView.layoutManager = LinearLayoutManager(this)

        // Sample Data
        surveyList = arrayListOf(
            Survey("1", "CS101", "Computer Science", "150"),
            Survey("2", "MTH102", "Mathematics", "130"),
            Survey("3", "PHY103", "Physics", "120"),
            Survey("4", "CHE104", "Chemistry", "110"),
            Survey("5", "ENG105", "English", "100")
        )

        surveyAdapter = SurveyAdapter(surveyList)
        recyclerView.adapter = surveyAdapter
    }
}
