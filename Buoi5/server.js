// server.js
const express = require('express');
const session = require('express-session');
const mysql = require('mysql');
const crypto = require('crypto');

const app = express();
const port = 3000;

// Kết nối CSDL
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root', // Tên người dùng của MySQL
  password: '', // Mật khẩu của MySQL
  database: 'buoi5' // Tên CSDL
});

// Kết nối đến CSDL
db.connect((err) => {
  if (err) {
    throw err;
  }
  console.log('Connected to database');
});

// Sử dụng session
app.use(session({
  secret: 'secret-key',
  resave: false,
  saveUninitialized: false
}));

// Sử dụng middleware để phân tích các yêu cầu gửi đi
app.use(express.urlencoded({ extended: false }));

// Định nghĩa form nhập thông tin
app.get('/', (req, res) => {
  res.send(`
  <h1 style="color: blue;">THÔNG TIN ĐĂNG KÝ THÀNH VIÊN</h1>
  <form action="/submit" method="post">
      <table>
      <tr> 
          <td><lable>Họ và tên</lable></td>
          <td><input type="text" name="name" placeholder="Họ và tên"><br></td> 
      </tr>
      <tr>    
          <td><lable>Địa chỉ Email</lable></td>
          <td><input type="text" name="email" placeholder="Email"><br></td>
      </tr>
      <tr>  
          <td><lable>Mật khẩu</lable></td>
          <td><input type="password" name="password" placeholder="Mật khẩu"><br></td>
      </tr>
      <tr>      
          <td><lable>Năm sinh</lable></td>
          <td><input type="text" name="dob" placeholder="Năm sinh"><br></td>
      </tr>
      <tr> 
          <td><lable>Giới tính</lable></td>
          <td>
              <input type="radio" name="gender" value="Nam"> Nam
              <input type="radio" name="gender" value="Nữ"> Nữ<br>
          </td>
      </tr>
          <td></td> 
          <td><button type="submit">Đăng ký</button><button type="reset">Xóa Form</button></td>
      </table>
  </form>
  <p>Bạn đã có tài khoản đăng nhập ngay!</p>
  <button><a href="/login">Đăng nhập</a></button>

`);
});

// Xử lý submit form và lưu vào CSDL
app.post('/submit', (req, res) => {
  const { name, email, password, dob, gender } = req.body;
  // Mã hóa mật khẩu bằng SHA1
  const hashedPassword = crypto.createHash('sha1').update(password).digest('hex');
  const insertQuery = `INSERT INTO users (name, email, password, dob, gender) VALUES ('${name}', '${email}', '${hashedPassword}', '${dob}', '${gender}')`;
  db.query(insertQuery, (err, result) => {
      if (err) {
          res.send('Error occurred while saving data.');
          throw err;
      }
      res.redirect('/login');
  });
});

// Kiểm tra xem người dùng đã đăng nhập chưa
function isAuthenticated(req, res, next) {
  if (req.session.loggedin) {
    return next();
  } else {
    res.redirect('/login');
  }
}

// Trang đăng nhập
app.get('/login', (req, res) => {
  if (req.session.loggedin) {
    res.redirect('/profile');
  } else {
    res.send(`
      <h1 style="color: blue;">Đăng nhập</h1>
        <form action="/login" method="post">
          <table>
            <tr>    
              <td><lable>Địa chỉ Email: </lable></td>
              <td><input type="text" name="email" placeholder="Email"><br></td>
            </tr>
            <tr>  
              <td><lable>Mật khẩu</lable></td>
              <td><input type="password" name="password" placeholder="Mật khẩu"><br></td>
            </tr>
            <tr>  
              <td><button type="submit">Đăng nhập</button></td>
             </tr>
          </table>
        </form>
    `);
  }
});

// Xử lý đăng nhập
app.post('/login', (req, res) => {
  const { email, password } = req.body;
  const hashedPassword = crypto.createHash('sha1').update(password).digest('hex');
  const query = `SELECT * FROM users WHERE email = '${email}' AND password = '${hashedPassword}'`;
  db.query(query, (err, result) => {
    if (err) {
      throw err;
    }
    if (result.length > 0) {
      req.session.loggedin = true;
      req.session.userId = result[0].id;
      req.session.name = result[0].name;
      req.session.email = result[0].email;
      req.session.dob = result[0].dob;
      req.session.gender = result[0].gender;
      res.redirect('/profile');
    } else {
      res.send('Email hoặc mật khẩu không đúng.');
    }
    res.end();
  });
});

// Trang đăng xuất
app.get('/logout', isAuthenticated, (req, res) => {
  req.session.destroy(err => {
    if (err) {
      console.error(err);
    } else {
      res.redirect('/login');
    }
  });
});

// Trang hiển thị thông tin cá nhân
app.get('/profile', isAuthenticated, (req, res) => {
  res.send(`
    <h1 style="color: blue;">Thông tin cá nhân của bạn</h1>
    <p>Họ và tên: ${req.session.name}</p>
    <p>Email: ${req.session.email}</p>
    <p>Năm sinh: ${req.session.dob}</p>
    <p>Giới tính: ${req.session.gender}</p>
    <br>
    
    <button><a href="/logout">Đăng xuất</a></button>
    <br>
    <button><a href="/update-profile">Cập nhật thông tin cá nhân</a></button>
  `);
});

// Trang cập nhật thông tin cá nhân
app.get('/update-profile', isAuthenticated, (req, res) => {
  res.send(`
    <h1 style="color: blue;">Cập nhật thông tin cá nhân</h1>
    <form action="/update-profile" method="post">
        <table>
          <tr>    
            <td><lable>Họ và tên </lable></td>
            <td><input type="text" name="name" placeholder="Họ và tên" value="${req.session.name}"><br></td>
          </tr>
          <tr>  
            <td><lable>Năm sinh</lable></td>
            <td><input type="text" name="dob" placeholder="Năm sinh" value="${req.session.dob}"><br></td>
          </tr>
          <tr>  
            <td><lable>Giới tính</lable></td>
            <td><input type="text" name="gender" placeholder="Giới tính" value="${req.session.gender}"><br></td>
          </tr>
          <tr>  
            <td><button type="submit">Cập nhật</button></td>
           </tr>
        </table>

    </form>
  `);
});

// Xử lý cập nhật thông tin cá nhân
app.post('/update-profile', isAuthenticated, (req, res) => {
  const { name, dob, gender } = req.body;
  const userEmail = req.session.email; // Lấy email từ session
  const query = `UPDATE users SET name='${name}', dob='${dob}', gender='${gender}' WHERE email='${userEmail}'`;
  db.query(query, (err, result) => {
    if (err) {
      throw err;
    }
    // Cập nhật lại thông tin trong session
    req.session.name = name;
    req.session.dob = dob;
    req.session.gender = gender;
    res.redirect('/profile');
  });
});


// Khởi động server
app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
