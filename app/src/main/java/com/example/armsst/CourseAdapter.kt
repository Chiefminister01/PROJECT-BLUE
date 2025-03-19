package com.example.armsst

import android.content.Context
import android.content.Intent
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView

class CourseAdapter(private val courseList: List<Course>,private val context:Context) :
    RecyclerView.Adapter<CourseAdapter.CourseViewHolder>() {

    class CourseViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val courseImage: ImageView = itemView.findViewById(R.id.courseImage)
        val courseTitle: TextView = itemView.findViewById(R.id.courseTitle)
        val courseCode: TextView = itemView.findViewById(R.id.courseCode)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): CourseViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.course_item1, parent, false)
        return CourseViewHolder(view)
    }

    override fun onBindViewHolder(holder: CourseViewHolder, position: Int) {
        val course = courseList[position]
        holder.courseImage.setImageResource(course.imageResId)
        holder.courseTitle.text = course.title
        holder.courseCode.text = course.code

        holder.itemView.setOnClickListener {
            context.startActivity(Intent(context,Inside_Course::class.java))
        }
    }

    override fun getItemCount(): Int {
        return courseList.size
    }
}
