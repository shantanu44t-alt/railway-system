package com.railway;

import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.PreparedStatement;

@WebServlet("/book")
public class PassengerServlet extends HttpServlet {
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();

        try {
            int passengerId = Integer.parseInt(request.getParameter("passengerId"));
            String name = request.getParameter("name");
            int age = Integer.parseInt(request.getParameter("age"));
            String gender = request.getParameter("gender");
            String phone = request.getParameter("phone");

            String sql = "INSERT INTO Passenger (Passenger_ID, Name, Age, Gender, Phone) VALUES (?, ?, ?, ?, ?)";

            try (Connection con = DBConnection.getConnection();
                 PreparedStatement ps = con.prepareStatement(sql)) {

                ps.setInt(1, passengerId);
                ps.setString(2, name);
                ps.setInt(3, age);
                ps.setString(4, gender);
                ps.setString(5, phone);

                ps.executeUpdate();
            }

            out.println("<html><head><title>Success</title>");
            out.println("<link rel='stylesheet' href='style.css'></head><body>");
            out.println("<div class='result success'><h2>Booking Data Saved!</h2>");
            out.println("<p>Passenger <b>" + escapeHtml(name) + "</b> was saved successfully.</p>");
            out.println("<a href='index.html'>Back to Reservation Page</a></div></body></html>");

        } catch (Exception e) {
            out.println("<html><head><title>Error</title>");
            out.println("<link rel='stylesheet' href='style.css'></head><body>");
            out.println("<div class='result error'><h2>Unable to save data</h2>");
            out.println("<p>Check the database connection, Passenger_ID, or duplicate phone/ID.</p>");
            out.println("<a href='index.html'>Back</a></div></body></html>");
            e.printStackTrace();
        }
    }

    private String escapeHtml(String value) {
        return value == null ? "" : value.replace("&", "&amp;")
                .replace("<", "&lt;").replace(">", "&gt;")
                .replace("\"", "&quot;").replace("'", "&#39;");
    }
}
