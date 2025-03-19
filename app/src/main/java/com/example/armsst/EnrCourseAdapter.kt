package com.example.armsst

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.RadioButton
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView

class Enr_Course_Adapter(private val courseList: List<Enr_Courses>) :
    RecyclerView.Adapter<Enr_Course_Adapter.CourseViewHolder>() {

    inner class CourseViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val radioButton: RadioButton = itemView.findViewById(R.id.courseRadioButton)
        val courseDetails: TextView = itemView.findViewById(R.id.courseDetailsTextView)
        val seatsAvailable: TextView = itemView.findViewById(R.id.seatsAvailableTextView)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): CourseViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.enr_course_item, parent, false)
        return CourseViewHolder(view)
    }

    override fun onBindViewHolder(holder: CourseViewHolder, position: Int) {
        val course = courseList[position]
        holder.courseDetails.text = "${course.courseCode} - ${course.courseName} - ${course.instructor}"
        holder.seatsAvailable.text = "${course.seatsAvailable}"
    }

    override fun getItemCount() = courseList.size
}
