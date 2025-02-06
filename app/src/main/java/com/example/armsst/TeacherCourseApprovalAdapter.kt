import android.annotation.SuppressLint
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.armsst.R

class TeacherCourseApprovalAdapter(
    private val studentList: List<Student>,
    private val onApproveClick: (Student) -> Unit,
    private val onRejectClick: (Student) -> Unit
) : RecyclerView.Adapter<TeacherCourseApprovalAdapter.ViewHolder>() {

    class ViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val regNo: TextView = view.findViewById(R.id.studentRegNo)
        val name: TextView = view.findViewById(R.id.studentName)
        val slot: TextView = view.findViewById(R.id.slot)
        val approveButton: Button = view.findViewById(R.id.approveButton)
        val rejectButton: Button = view.findViewById(R.id.rejectButton)
    }


    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.student_item, parent, false)
        return ViewHolder(view)
    }

    @SuppressLint("SetTextI18n")
    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val student = studentList[position]
        holder.regNo.text = "Reg No: ${student.regNo}"
        holder.name.text = "Name: ${student.name}"
        holder.slot.text = "Slot: ${student.slot}"

        holder.approveButton.setOnClickListener { onApproveClick(student) }
        holder.rejectButton.setOnClickListener { onRejectClick(student) }
    }

    override fun getItemCount() = studentList.size
}
