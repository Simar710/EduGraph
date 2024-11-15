Sub CreateUI()

    ' Create a new worksheet for the UI
    Sheets.Add(After:=Sheets(Sheets.Count)).Name = "InputSheets"
    Sheets("InputSheets").Activate
    
    
    ActiveSheet.Cells(1, 1).Value = "Courses Completed:"
    ActiveSheet.Cells(1, 2).Value = "Credits Completed:"
    
    Cells.Select
    Cells.EntireColumn.AutoFit
    
    MsgBox ("InputSheet has been created, please add courses one cell at a time in the A column and add the number for credits completed in B2")
        
End Sub
