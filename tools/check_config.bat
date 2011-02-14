@set filename=%0
@for %%F in (%filename%) do @set dirname=%%~dpF
@php.exe %dirname%check_config.php
@pause