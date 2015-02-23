/********************************************/
/*dataWarehouseRequest.php					*/
/********************************************/

This file send a request to Data Warehouse, if successful a requestID is returned and button cancel request and checker request are displayed

/********************************************/
/*dataWarehouseRequestCancel.php			*/
/********************************************/

This file cancel a Data Warehouse request. The query parameters requestID (DW request ID submitted) and RSID (Adobe Analytics report suite ID) needs to be specified.
For manual test for this file without using dataWarehouseRequest.php, specify the 2 parameters above as query params

/********************************************/
/*dataWarehouseRequestChecker.php			*/
/********************************************/

Check the status of the Data Warehouse request ID. The query parameters requestID (DW request ID submitted) and RSID (Adobe Analytics report suite ID) needs to be specified.
For manual test for this file without using dataWarehouseRequest.php, specify the 2 parameters above as query params.
If the status is completed, an addtional button should be displayed : the button will redirect to dataWarehouseRequestGetData.php

/********************************************/
/*dataWarehouseRequestChecker.php			*/
/********************************************/

Return the data of the Data Warehouse request ID. The query parameters requestID (DW request ID submitted) and RSID (Adobe Analytics report suite ID) needs to be specified.
For manual test for this file without using dataWarehouseRequest.php, specify the 2 parameters above as query params.
