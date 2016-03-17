<%
response.write("sadasd")

Set Mail = Server.CreateObject("Persits.MailSender")
on Error Resume Next ' catch errors
   Mail.Send	' send message
   If Err <> 0 Then ' error occurred
      sresponse.write("errror")
   End If
   on Error goto 0

   ' enter valid SMTP host
   Mail.Host = "localhost"

   Mail.From = "slov1@hotmail.com"
   Mail.FromName = "slov1@hotmail.com"
   Mail.AddAddress "scott@kobecreations.com"

   ' message subject
   Mail.Subject = "asdasd"
   ' message body
   Mail.Body = "asdasdasd"
   strErr = ""
   bSuccess = False
   On Error Resume Next ' catch errors
   Mail.Send	' send message
   If Err <> 0 Then ' error occurred
      strErr = Err.Description
   else
      bSuccess = True
   End If

'Set myMail=CreateObject("CDO.Message")
'myMail.Subject="Sending email with CDO"
'myMail.From="scott@kobecreations.com"
'myMail.To="someone@somedomain.com"
'myMail.TextBody="This is a message."
'myMail.AddAttachment "c:\mydocuments\test.txt"
'myMail.Send
'set myMail=nothing

'Set JMail = Server.CreateObject("Jmail.smtpmail")
'JMail.Sender = "scott@kobecreations.com"
'JMail.AddRecipient("scott@kobecreations.com")
'JMail.Subject = "asd"
'JMail.Body = "Asdasd"
'JMail.HTMLBody = "Asdasd"

'If instr(LCase(vstrTo),"@sdi.com.au")>0 then
''	JMail.ServerAddress = "webmail.sdi.com.au"
'Else
''	JMail.ServerAddress = "localhost"
'End IF


''	JMail.Execute()

'Set JMail = Nothing


%>

done