package com.example.armsst

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView

data class StudyMaterial(val title: String, val link: String)

class StudyMaterialAdapter(private val materials: List<StudyMaterial>) :
    RecyclerView.Adapter<StudyMaterialAdapter.ViewHolder>() {

    class ViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val tvTitle: TextView = itemView.findViewById(R.id.tvMaterialTitle)
        val tvLink: TextView = itemView.findViewById(R.id.tvMaterialLink)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.study_material_item, parent, false)
        return ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val material = materials[position]
        holder.tvTitle.text = material.title
        holder.tvLink.text = material.link
    }

    override fun getItemCount(): Int = materials.size
}
