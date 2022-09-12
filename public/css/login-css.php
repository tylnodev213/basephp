<style>
*{
    margin:0;
    padding:0;
    box-sizing: border-box;
    font-size:16px;
}
body {
  font-family: "Poppins", sans-serif;
  height: 100vh;
  background-color: white;
}

a {
    width:85%;
  color: #5555f4;
  display:inline-block;
  text-decoration: underline;
  text-align: right;
  font-weight: 400;
}

h2 {
  text-align: left;
  margin: 5px;
  font-size:16px;
  font-weight: 600;
  display:inline-block;
  margin: 10px 0px; 
  color: #666666;
}
    .wrapper {
  display: flex;
  align-items: center;
  flex-direction: column; 
  justify-content: center;
  width: 100%;
  min-height: 100%;
  padding: 20px;
}

#formContent {
  -webkit-border-radius: 10px 10px 10px 10px;
  border-radius: 10px 10px 10px 10px;
  background: #fff;
  padding: 30px;
  width: 90%;
  max-width: 450px;
  position: relative;
  padding: 0px;
}
input[type="text"], input[type="password"] {
    width: 85%;
    height: 40px;
    border: 1px solid #bddad5;
    padding: 10px;
    border-radius: 5px;
}
.validate{
    font-weight: bold;
}
#login_withFb{
    text-align: right;
}
input[type="submit"] {
    background-color: #1ba1e2;
    padding: 10px 30px;
    border-radius: 5px;
    color: white;
    border: none;
    text-align:center;
    margin: auto;
}
.row{
    width: 85%;
}
</style>