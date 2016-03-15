<?php
namespace Leo\ExcelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('LeoUserBundle:User')->findAll();
        $xls = new \PHPExcel();
        $xls->getProperties()->setCreator("Victor");
        $sheet = $xls->setActiveSheetIndex();
//        $sheet = $xls->getSheet();
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue("A1", "Users");
        $sheet->setCellValueByColumnAndRow(0, 2, "Id")
            ->setCellValueByColumnAndRow(1, 2, "Username")
            ->setCellValueByColumnAndRow(2, 2, "Email")
            ->setCellValueByColumnAndRow(3, 2, "Role")
            ->setCellValueByColumnAndRow(4, 2, "IsActive");
//        $sheet->getDefaultColumnDimension()->setWidth(50);
        $row = 2;
        foreach($users as $user) {
            $sheet->setCellValueByColumnAndRow(0, ++$row, $user->getId())
                ->setCellValueByColumnAndRow(1, $row, $user->getUsername())
                ->setCellValueByColumnAndRow(2, $row, $user->getEmail())
                ->setCellValueByColumnAndRow(3, $row, $this->get('translator')->trans($user->getRole()->getRole(), array(), 'LeoUserBundle'))
                ->setCellValueByColumnAndRow(4, $row, $user->getIsActive() ? "active" : "inactive");
//            $sheet->getCellByColumnAndRow(4, $row)->setDataType("s");
//            $sheet->getCellByColumnAndRow(4, $row)->getStyle()->getNumberFormat()->setFormatCode("BOOLEAN");
//            $sheet->getCellByColumnAndRow(4, $row)->setValue(0);
        }
        $sheet->setCellValueByColumnAndRow(0, ++$row, $sheet->getCellByColumnAndRow(0, $row - 1)->getDataType())
            ->setCellValueByColumnAndRow(1, $row, $sheet->getCellByColumnAndRow(1, $row - 1)->getDataType())
            ->setCellValueByColumnAndRow(2, $row, $sheet->getCellByColumnAndRow(2, $row - 1)->getDataType())
            ->setCellValueByColumnAndRow(3, $row, $sheet->getCellByColumnAndRow(3, $row - 1)->getDataType())
            ->setCellValueByColumnAndRow(4, $row, $sheet->getCellByColumnAndRow(4, $row - 1)->getDataType());
        $cell_style = $sheet->getStyleByColumnAndRow(0, 0, 4, $row);
        $cell_style->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
        $sheet->getStyleByColumnAndRow(0, 0, 4, $row)->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $sheet->getStyleByColumnAndRow(0, 0, 4, $row)->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $sheet->getStyleByColumnAndRow(0, 0, 4, $row)->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $sheet->getStyleByColumnAndRow(0, 0, 4, $row)->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_MEDIUM);
        $cell_style->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_GENERAL);
        $cell_style->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWriter = new \PHPExcel_Writer_Excel5($xls);
//        $objWriter = \PHPExcel_IOFactory::createWriter($xls, "Excel2007");
//        $objWriter->save('users.xls');
        $response = new Response();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment; filename="users.xls"');
        $response->headers->set('Cache-Control', 'max-age=0');
        $response->sendHeaders();
        $objWriter->save('php://output');
        return $response;
    }
}
