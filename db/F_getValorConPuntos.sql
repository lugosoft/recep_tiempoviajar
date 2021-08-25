CREATE FUNCTION dbo.getValorConPuntos(@pValor bigint)
returns varchar(25)
as  
BEGIN
  DECLARE @val varchar(25);
	DECLARE @lon integer;
		SET @lon = 0;
		SET @val = ''+@pValor;
    SET @lon =  DATALENGTH(@val);
		
		IF ((@lon >= 4 ) and (@lon <= 6)) BEGIN
			SET @val = SUBSTRING(@val,1,@lon-3) + '.' + SUBSTRING(@val,@lon-2,3);
		END
    
    IF ((@lon >= 7 ) and (@lon <= 9)) BEGIN
			SET @val = SUBSTRING(@val,1,@lon-6) + '.' + SUBSTRING(@val,@lon-5,3) + '.' + SUBSTRING(@val,@lon-2,3);
		END
    
    IF (@lon >=10) BEGIN
			SET @val = SUBSTRING(@val,1,@lon-9) + '.' + SUBSTRING(@val,@lon-8,3) + '.' + SUBSTRING(@val,@lon-5,3) + '.' + SUBSTRING(@val,@lon-2,3);
		END;
		
		return @val;      
END

GO



-- Otra forma de crearla
CREATE FUNCTION dbo.getValorConPuntos(@pValor bigint)
returns varchar(25)
as  
BEGIN
  DECLARE @val varchar(25)
	DECLARE @lon integer
		SET @lon = 0
		SET @val = ''+@pValor
    SET @lon =  DATALENGTH(@val)
		
		IF ((@lon >= 4 ) and (@lon <= 6)) BEGIN
			SET @val = SUBSTRING(@val,1,@lon-3) + '.' + SUBSTRING(@val,@lon-2,3)
		END
    
    IF ((@lon >= 7 ) and (@lon <= 9)) BEGIN
			SET @val = SUBSTRING(@val,1,@lon-6) + '.' + SUBSTRING(@val,@lon-5,3) + '.' + SUBSTRING(@val,@lon-2,3)
		END
    
    IF (@lon >=10) BEGIN
			SET @val = SUBSTRING(@val,1,@lon-9) + '.' + SUBSTRING(@val,@lon-8,3) + '.' + SUBSTRING(@val,@lon-5,3) + '.' + SUBSTRING(@val,@lon-2,3)
		END
		
		return @val 
END;