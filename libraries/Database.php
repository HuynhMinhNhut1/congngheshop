<?php 
    // Định nghĩa lớp Database
    class Database
    {
        /**
         * Khai báo biến kết nối
         * @var [type]
         */
        public $link;
        // Hàm khởi tạo
        public function __construct()
        {
            // Kết nối đến cơ sở dữ liệu
            $this->link = mysqli_connect("localhost","root","","shopcongnghe") or die ();
            // Thiết lập mã hóa ký tự là utf8
            mysqli_set_charset($this->link,"utf8");
        }
        /**
         * Hàm thêm mới bản ghi vào cơ sở dữ liệu
         * @param  $table - tên bảng
         * @param  array  $data  - dữ liệu cần thêm
         * @return integer - trả về ID của bản ghi vừa thêm
         */
        public function insert($table, array $data)
        {
            // Khởi tạo câu lệnh SQL
            $sql = "INSERT INTO {$table} ";
            // Tách các khóa và giá trị của mảng dữ liệu
            $columns = implode(',', array_keys($data));
            $values  = "";
            $sql .= '(' . $columns . ')';
            foreach($data as $field => $value) {
                if(is_string($value)) {
                    $values .= "'". mysqli_real_escape_string($this->link,$value) ."',";
                } else {
                    $values .= mysqli_real_escape_string($this->link,$value) . ',';
                }
            }
            // Loại bỏ dấu phẩy cuối cùng
            $values = substr($values, 0, -1);
            $sql .= " VALUES (" . $values . ')';
            // Thực thi câu lệnh SQL
            mysqli_query($this->link, $sql) or die("Lỗi query insert ----" .mysqli_error($this->link));
            // Trả về ID của bản ghi vừa thêm
            return mysqli_insert_id($this->link);
        }

        /**
         * Hàm cập nhật bản ghi
         * @param  $table - tên bảng
         * @param  array  $data - dữ liệu cần cập nhật
         * @param  array  $conditions - điều kiện cập nhật
         * @return integer - số lượng bản ghi bị ảnh hưởng
         */
        public function update($table, array $data, array $conditions)
        {
            $sql = "UPDATE {$table}";
            $set = " SET ";
            $where = " WHERE ";

            foreach($data as $field => $value) {
                if(is_string($value)) {
                    $set .= $field .'='.'\''. mysqli_real_escape_string($this->link, xss_clean($value)) .'\',';
                } else {
                    $set .= $field .'='. mysqli_real_escape_string($this->link, xss_clean($value)) . ',';
                }
            }

            $set = substr($set, 0, -1);

            foreach($conditions as $field => $value) {
                if(is_string($value)) {
                    $where .= $field .'='.'\''. mysqli_real_escape_string($this->link, xss_clean($value)) .'\' AND ';
                } else {
                    $where .= $field .'='. mysqli_real_escape_string($this->link, xss_clean($value)) . ' AND ';
                }
            }

            $where = substr($where, 0, -5);

            $sql .= $set . $where;
            // Thực thi câu lệnh SQL
            mysqli_query($this->link, $sql) or die("Lỗi truy vấn Update -- " .mysqli_error());

            return mysqli_affected_rows($this->link);
        }

        // Hàm cập nhật bản ghi với câu lệnh SQL cụ thể
        public function updateview($sql)
        {
            $result = mysqli_query($this->link, $sql)  or die ("Lỗi update view " .mysqli_error($this->link));
            return mysqli_affected_rows($this->link);
        }
        
        // Hàm đếm số lượng bản ghi trong bảng
        public function countTable($table)
        {
            $sql = "SELECT id FROM  {$table}";
            $result = mysqli_query($this->link, $sql) or die("Lỗi Truy Vấn countTable----" .mysqli_error($this->link));
            $num = mysqli_num_rows($result);
            return $num;
        }

        /**
         * Hàm xóa bản ghi
         * @param  $table - tên bảng
         * @param  $id - id của bản ghi cần xóa
         * @return integer - số lượng bản ghi bị xóa
         */
        public function delete($table ,  $id)
        {
            $sql = "DELETE FROM {$table} WHERE id = $id ";
            mysqli_query($this->link, $sql) or die (" Lỗi Truy Vấn delete --- " .mysqli_error($this->link));
            return mysqli_affected_rows($this->link);
        }

        // Hàm xóa nhiều bản ghi theo mảng id
        public function deletewhere($table, $data = array())
        {
            foreach ($data as $id)
            {
                $id = intval($id);
                $sql = "DELETE FROM {$table} WHERE id = $id ";
                mysqli_query($this->link, $sql) or die (" Lỗi Truy Vấn delete --- " .mysqli_error($this->link));
            }
            return true;
        }

        // Hàm thực thi câu lệnh SQL và trả về dữ liệu
        public function fetchsql($sql)
        {
            $result = mysqli_query($this->link, $sql) or die("Lỗi truy vấn sql " .mysqli_error($this->link));
            $data = [];
            if($result)
            {
                while ($num = mysqli_fetch_assoc($result))
                {
                    $data[] = $num;
                }
            }
            return $data;
        } 
        
        // Hàm lấy bản ghi theo id
        public function fetchID($table, $id)
        {
            $sql = "SELECT * FROM {$table} WHERE id = $id ";
            $result = mysqli_query($this->link, $sql) or die("Lỗi truy vấn fetchID " .mysqli_error($this->link));
            return mysqli_fetch_assoc($result);
        }

        // Hàm lấy một bản ghi với điều kiện truy vấn
        public function fetchOne($table, $query)
        {
            $sql = "SELECT * FROM {$table} WHERE ";
            $sql .= $query;
            $sql .= " LIMIT 1";
            $result = mysqli_query($this->link, $sql) or die("Lỗi truy vấn fetchOne " .mysqli_error($this->link));
            return mysqli_fetch_assoc($result);
        }

        // Hàm xóa bản ghi với câu lệnh SQL cụ thể
        public function deletesql($table, $sql)
        {
            $sql = "DELETE FROM {$table} WHERE " .$sql;
            // Thực thi câu lệnh SQL
            mysqli_query($this->link, $sql) or die (" Lỗi Truy Vấn delete --- " .mysqli_error($this->link));
            return mysqli_affected_rows($this->link);
        }

        // Hàm lấy tất cả bản ghi trong bảng
        public function fetchAll($table)
        {
            $sql = "SELECT * FROM {$table} WHERE 1";
            $result = mysqli_query($this->link, $sql) or die("Lỗi Truy Vấn fetchAll " .mysqli_error($this->link));
            $data = [];
            if($result)
            {
                while ($num = mysqli_fetch_assoc($result))
                {
                    $data[] = $num;
                }
            }
            return $data;
        }

        // Hàm lấy các bản ghi trong bảng với điều kiện Home = 1
        public function fetchcate($table)
        {
            $sql = "SELECT * FROM {$table} WHERE Home = 1";
            $result = mysqli_query($this->link, $sql) or die("Lỗi Truy Vấn fetchcate " .mysqli_error($this->link));
            $data = [];
            if($result)
            {
                while ($num = mysqli_fetch_assoc($result))
                {
                    $data[] = $num;
                }
            }
            return $data;
        }

        // Hàm lấy các bản ghi với phân trang
        public function fetchJones($table, $sql, $page = 0, $row, $pagi = false)
        {
            $data = [];

            if ($pagi == true)
            {
                $total = $this->countTable($table);
                $sotrang = ceil($total / $row);
                $start = ($page - 1) * $row;
                $sql .= " LIMIT $start, $row";
                $data = ["page" => $sotrang];
                $result = mysqli_query($this->link, $sql) or die("Lỗi truy vấn fetchJone ---- " .mysqli_error($this->link));
            }
            else
            {
                $result = mysqli_query($this->link, $sql) or die("Lỗi truy vấn fetchJone ---- " .mysqli_error($this->link));
            }

            if($result)
            {
                while ($num = mysqli_fetch_assoc($result))
                {
                    $data[] = $num;
                }
            }

            return $data;
        }

                // Hàm lấy các bản ghi với phân trang (phiên bản khác)
        public function fetchJone($table, $sql, $page = 0, $row, $pagi = false)
        {
            $data = [];
            if ($pagi == true)
            {
                $total = $this->countTable($table);
                $sotrang = ceil($total / $row);
                $start = ($page - 1) * $row;
                $sql .= " LIMIT $start,$row";
                $data = ["page" => $sotrang];
                $result = mysqli_query($this->link, $sql) or die("Lỗi truy vấn fetchJone ---- " .mysqli_error($this->link));
            }
            else
            {
                $result = mysqli_query($this->link, $sql) or die("Lỗi truy vấn fetchJone ---- " .mysqli_error($this->link));
            }
            
            if ($result)
            {
                while ($num = mysqli_fetch_assoc($result))
                {
                    $data[] = $num;
                }
            }
            return $data;
        }

        // Hàm lấy các bản ghi chi tiết với phân trang
        public function fetchJoneDetail($table, $sql, $page = 0, $total, $pagi)
        {
            $result = mysqli_query($this->link, $sql) or die("Lỗi truy vấn fetchJone ---- " .mysqli_error($this->link));
            $sotrang = ceil($total / $pagi);
            $start = ($page - 1) * $pagi;
            $sql .= " LIMIT $start, $pagi";
            $result = mysqli_query($this->link, $sql);
            $data = [];
            $data = ["page" => $sotrang];
            if ($result)
            {
                while ($num = mysqli_fetch_assoc($result))
                {
                    $data[] = $num;
                }
            }
            return $data;
        }

        // Hàm tính tổng
        public function total($sql)
        {
            $result = mysqli_query($this->link, $sql);
            $tien = mysqli_fetch_assoc($result);
            return $tien;
        }
    }
?>
