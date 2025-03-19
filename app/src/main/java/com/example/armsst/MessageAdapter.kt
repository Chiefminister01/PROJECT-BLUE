package com.example.armsst

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView

data class Message(val teacherName: String, val message: String)

class MessageAdapter(private val messages: List<Message>) :
    RecyclerView.Adapter<MessageAdapter.ViewHolder>() {

    class ViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val tvTeacherName: TextView = itemView.findViewById(R.id.tvTeacherName)
        val tvTeacherMessage: TextView = itemView.findViewById(R.id.tvTeacherMessage)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.message_item, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val message = messages[position]
        holder.tvTeacherName.text = message.teacherName
        holder.tvTeacherMessage.text = message.message
    }

    override fun getItemCount(): Int = messages.size
}
