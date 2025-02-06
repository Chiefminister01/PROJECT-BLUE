package com.example.armsst

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.armsst.com.example.armsst.Survey

class SurveyAdapter(private val surveyList: List<Survey>) :
    RecyclerView.Adapter<SurveyAdapter.SurveyViewHolder>() {

    class SurveyViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val serialNumber: TextView = view.findViewById(R.id.serialNumber)
        val courseCode: TextView = view.findViewById(R.id.courseCode)
        val courseName: TextView = view.findViewById(R.id.courseName)
        val totalEnrolled: TextView = view.findViewById(R.id.totalEnrolled)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): SurveyViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.course_item, parent, false)
        return SurveyViewHolder(view)
    }

    override fun onBindViewHolder(holder: SurveyViewHolder, position: Int) {
        val survey = surveyList[position]
        holder.serialNumber.text = survey.serialNumber
        holder.courseCode.text = survey.courseCode
        holder.courseName.text = survey.courseName
        holder.totalEnrolled.text = survey.totalEnrolled
    }

    override fun getItemCount() = surveyList.size
}

