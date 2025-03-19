package com.example.armsst

data class Enr_Courses(
    val courseCode: String,
    val courseName: String,
    val slot: String,
    val maxStudents: Int,
    val enrolledStudents: Int
)