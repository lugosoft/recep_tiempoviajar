CREATE FUNCTION dbo.getHoraRecogida(@pHora varchar(10), @pNumHoras integer)
returns varchar(8)
as
BEGIN
  DECLARE @num integer = 0;
  DECLARE @hora varchar(8) = null;
  SET @num = CAST(SUBSTRING(@pHora,1,2) AS INTEGER);
  SET @num = @num - @pNumHoras;
  
  IF (@num = 0) BEGIN
    SET @hora = '00';
  END

  IF (@num < 0) BEGIN
    SET @hora = CAST(@num+24 AS VARCHAR);
  END
  
  IF ((@num > 0) and (@num <= 9)) BEGIN
    --SET @hora = '0'+@num;
    SET @hora = '0'+CAST(@num AS VARCHAR);
  END  
  
  IF (@num > 9) BEGIN
    SET @hora = CAST(@num AS VARCHAR);
  END 

  return @hora+':'+SUBSTRING(@pHora,4,2);         
END

GO



-- Otra forma de crearla
CREATE FUNCTION dbo.getHoraRecogida(@pHora varchar(10), @pNumHoras integer)
returns varchar(8)
as
BEGIN
  DECLARE @num integer = 0
  DECLARE @hora varchar(8) = null
  SET @num = CAST(SUBSTRING(@pHora,1,2) AS INTEGER)
  SET @num = @num - @pNumHoras
  
  IF (@num = 0) BEGIN
    SET @hora = '00'
  END

  IF (@num < 0) BEGIN
    SET @hora = CAST(@num+24 AS VARCHAR)
  END
  
  IF ((@num > 0) and (@num <= 9)) BEGIN
    --SET @hora = '0'+@num;
    SET @hora = '0'+CAST(@num AS VARCHAR)
  END  
  
  IF (@num > 9) BEGIN
    SET @hora = CAST(@num AS VARCHAR)
  END 

  return @hora+':'+SUBSTRING(@pHora,4,2)
END;