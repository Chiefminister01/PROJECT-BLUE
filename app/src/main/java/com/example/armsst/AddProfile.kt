import android.os.Bundle
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import com.example.armsst.R
import com.example.armsst.api.RetrofitInstance
import com.example.armsst.dataModel.StudentResponse
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.RequestBody

class XPro : AppCompatActivity() {
    private lateinit var btnSubmit: Button

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.admin_add_profile)

        val etStudentName: EditText = findViewById(R.id.et_student_name)
        val etRegNo: EditText = findViewById(R.id.et_student_number)
        val etDob: EditText = findViewById(R.id.et_birthdate)
        val etCourse: EditText = findViewById(R.id.et_course)
        val etYear: EditText = findViewById(R.id.et_year)
        val etNationality: EditText = findViewById(R.id.et_nationality)
        val etEmail: EditText = findViewById(R.id.et_email)
        val etContact: EditText = findViewById(R.id.et_contact)
        val etAddress: EditText = findViewById(R.id.et_address)
        val etBio: EditText = findViewById(R.id.BIO)
        val etPassword: EditText = findViewById(R.id.PASS)
        val rgGender: RadioGroup = findViewById(R.id.rg_gender)

        btnSubmit = findViewById(R.id.btn_submit)

        btnSubmit.setOnClickListener {
            val name = etStudentName.text.toString().trim()
            val regNo = etRegNo.text.toString().trim()
            val dob = etDob.text.toString().trim()
            val course = etCourse.text.toString().trim()
            val year = etYear.text.toString().trim()
            val nationality = etNationality.text.toString().trim()
            val email = etEmail.text.toString().trim()
            val contact = etContact.text.toString().trim()
            val address = etAddress.text.toString().trim()
            val bio = etBio.text.toString().trim()
            val password = etPassword.text.toString().trim()

            val selectedGenderId = rgGender.checkedRadioButtonId
            if (selectedGenderId == -1) {
                Toast.makeText(this, "Please select gender", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }
            val gender = findViewById<RadioButton>(selectedGenderId).text.toString()

            if (name.isEmpty() || regNo.isEmpty() || dob.isEmpty() || course.isEmpty() || year.isEmpty() ||
                nationality.isEmpty() || email.isEmpty() || contact.isEmpty() || address.isEmpty() ||
                password.isEmpty() || gender.isEmpty()) {
                Toast.makeText(this, "All fields are required", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }

            uploadProfile(regNo, name, dob, course, year, nationality, contact, email, address, bio, gender, password)
        }
    }

    private fun uploadProfile(regNo: String, fullName: String, dob: String, course: String, year: String,
                              nationality: String, contact: String, email: String, address: String,
                              bio: String, gender: String, password: String) {

        val regNoPart = RequestBody.create("text/plain".toMediaTypeOrNull(), regNo)
        val fullNamePart = RequestBody.create("text/plain".toMediaTypeOrNull(), fullName)
        val dobPart = RequestBody.create("text/plain".toMediaTypeOrNull(), dob)
        val coursePart = RequestBody.create("text/plain".toMediaTypeOrNull(), course)
        val yearPart = RequestBody.create("text/plain".toMediaTypeOrNull(), year)
        val nationalityPart = RequestBody.create("text/plain".toMediaTypeOrNull(), nationality)
        val contactPart = RequestBody.create("text/plain".toMediaTypeOrNull(), contact)
        val emailPart = RequestBody.create("text/plain".toMediaTypeOrNull(), email)
        val addressPart = RequestBody.create("text/plain".toMediaTypeOrNull(), address)
        val bioPart = RequestBody.create("text/plain".toMediaTypeOrNull(), bio)
        val genderPart = RequestBody.create("text/plain".toMediaTypeOrNull(), gender)
        val passwordPart = RequestBody.create("text/plain".toMediaTypeOrNull(), password)

        val call = RetrofitInstance.apiService.addStudentProfile(
            regNoPart, fullNamePart, dobPart, coursePart, yearPart, nationalityPart,
            contactPart, emailPart, addressPart, bioPart, genderPart, passwordPart, null
        )

        call.enqueue(object : Callback<StudentResponse> {
            override fun onResponse(call: Call<StudentResponse>, response: Response<StudentResponse>) {
                if (response.isSuccessful && response.body()?.status == true) {
                    Toast.makeText(applicationContext, "Profile Added", Toast.LENGTH_SHORT).show()
                } else {
                    Toast.makeText(applicationContext, response.body()?.message ?: "Error", Toast.LENGTH_SHORT).show()
                }
            }

            override fun onFailure(call: Call<StudentResponse>, t: Throwable) {
                Toast.makeText(applicationContext, "Failed: ${t.message}", Toast.LENGTH_SHORT).show()
            }
        })
    }
}
