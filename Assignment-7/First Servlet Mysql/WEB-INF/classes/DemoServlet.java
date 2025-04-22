import jakarta.servlet.http.*;  
import jakarta.servlet.*;  
import java.io.*; 
import java.sql.*;  

public class DemoServlet extends HttpServlet {  

    public void doGet(HttpServletRequest req, HttpServletResponse res)  
    throws ServletException, IOException {  
        res.setContentType("text/html");  
        PrintWriter pw = res.getWriter();  
        
        pw.println("<html>");
        pw.println("<head>");
        pw.println("<style>");
        pw.println("body { font-family: Arial, sans-serif; background-color: #f2f2f2; }");
        pw.println(".container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }");
        pw.println("h2, h3 { text-align: center; color: #333; }");
        pw.println("form { margin-bottom: 30px; background: #eef; padding: 15px; border-radius: 8px; }");
        pw.println("input[type='text'], input[type='number'] { width: 95%; padding: 8px; margin: 5px 0; border: 1px solid #ccc; border-radius: 4px; }");
        pw.println("input[type='submit'] { background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }");
        pw.println("input[type='submit']:hover { background-color: #218838; }");
        pw.println("table { width: 100%; border-collapse: collapse; margin-top: 20px; }");
        pw.println("th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }");
        pw.println("th { background-color: #007bff; color: white; }");
        pw.println("</style>");
        pw.println("</head>");
        pw.println("<body>");
        pw.println("<div class='container'>");
        pw.println("<h2>Welcome to Pragati eBookShop</h2>");  
        
        // Form to Add Book
        pw.println("<h3>Add a New Book</h3>");
        pw.println("<form method='post' action='it'>");
        pw.println("Book Name: <input type='text' name='name' required><br>");
        pw.println("Author: <input type='text' name='author' required><br>");
        pw.println("Price: <input type='number' step='0.01' name='price' required><br>");
        pw.println("Quantity: <input type='number' name='quantity' required><br>");
        pw.println("<input type='submit' name='action' value='Add Book'>");
        pw.println("</form>");

        // Display Book List first
        pw.println("<h3>Book List</h3>");
        pw.println("<table>");  
        pw.println("<tr><th>Book Name</th><th>Author</th><th>Price</th><th>Quantity</th></tr>");
        
        try { 
            Class.forName("com.mysql.jdbc.Driver"); 
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/pragati", "root", ""); 
            Statement stmt = con.createStatement(); 
            ResultSet rs = stmt.executeQuery("SELECT * FROM ebookshop"); 
            
            while (rs.next()) {    
                pw.println("<tr><td>" + rs.getString("name") + "</td><td>" + rs.getString("author") + "</td><td>" + rs.getDouble("price") + "</td><td>" + rs.getInt("quantity") + "</td></tr>");
            }
        } catch(Exception e) { 
            pw.println("<p style='color:red;'>Error: " + e.getMessage() + "</p>"); 
        } 
        
        pw.println("</table>");

        // Form to Delete Book (moved below the table)
        pw.println("<h3>Delete a Book by Name</h3>");
        pw.println("<form method='post' action='it'>");
        pw.println("Book Name: <input type='text' name='name' required><br>");
        pw.println("<input type='submit' name='action' value='Delete Book'>");
        pw.println("</form>");

        pw.println("</div>");
        pw.println("</body></html>");    
        pw.close();  
    }  

    public void doPost(HttpServletRequest req, HttpServletResponse res)  
    throws ServletException, IOException {  
        res.setContentType("text/html");  
        PrintWriter pw = res.getWriter();  

        String action = req.getParameter("action");

        try { 
            Class.forName("com.mysql.jdbc.Driver"); 
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/pragati", "root", ""); 
            PreparedStatement ps;
            
            if ("Add Book".equals(action)) {
                String name = req.getParameter("name");
                String author = req.getParameter("author");
                double price = Double.parseDouble(req.getParameter("price"));
                int quantity = Integer.parseInt(req.getParameter("quantity"));
                
                ps = con.prepareStatement("INSERT INTO ebookshop (name, author, price, quantity) VALUES (?, ?, ?, ?)");
                ps.setString(1, name);
                ps.setString(2, author);
                ps.setDouble(3, price);
                ps.setInt(4, quantity);
                ps.executeUpdate();
                pw.println("<p>Book added successfully!</p>");
            } else if ("Delete Book".equals(action)) {
                String name = req.getParameter("name");
                
                ps = con.prepareStatement("DELETE FROM ebookshop WHERE name = ?");
                ps.setString(1, name);
                int rowsDeleted = ps.executeUpdate();
                if (rowsDeleted > 0) {
                    pw.println("<p>Book deleted successfully!</p>");
                } else {
                    pw.println("<p style='color:red;'> No book found with that name.</p>");
                }
            }
        } catch(Exception e) { 
            pw.println("<p style='color:red;'>Error: " + e.getMessage() + "</p>"); 
        }

        doGet(req, res); // Refresh the page
    }
}
