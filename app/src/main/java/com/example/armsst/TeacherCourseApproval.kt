import android.os.Bundle
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.armsst.R

class TeacherCourseApprovalActivity : AppCompatActivity() {

    private lateinit var studentRecyclerView: RecyclerView
    private lateinit var studentAdapter: TeacherCourseApprovalAdapter
    private val studentList = mutableListOf<Student>()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.teacher_course_approval)

        studentRecyclerView = findViewById(R.id.studentRecyclerView)

        // Sample Data
        studentList.add(Student("12345", "John Doe", "Morning"))
        studentList.add(Student("67890", "Jane Smith", "Afternoon"))

        studentAdapter = TeacherCourseApprovalAdapter(studentList,
            onApproveClick = { student -> Toast.makeText(this, "Approved: ${student.name}", Toast.LENGTH_SHORT).show() },
            onRejectClick = { student -> Toast.makeText(this, "Rejected: ${student.name}", Toast.LENGTH_SHORT).show() }
        )

        studentRecyclerView.layoutManager = LinearLayoutManager(this)
        studentRecyclerView.adapter = studentAdapter
    }
}
