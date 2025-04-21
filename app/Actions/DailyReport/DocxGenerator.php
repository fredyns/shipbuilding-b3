<?php

namespace App\Actions\DailyReport;

use App\Models\DailyReport;
use PhpOffice\PhpWord\ComplexType\ProofState;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Language;

const pCenter = 'pCenter';
const pJustify = 'pJustify';
const pText = 'pText';
const p = 'p';
const fBold = 'fBold';
const fTitle = 'fTitle';
const fLink = 'fLink';
const f = 'f';

class DocxGenerator
{
    protected DailyReport $dailyReport;
    protected PhpWord $phpWord;

    public function __construct(DailyReport $dailyReport)
    {
        $this->dailyReport = $dailyReport;
        $this->phpWord = new PhpWord();
    }

    public function run()
    {
        $this->setMetadata();
        $this->writeMinutes();

        return $this->phpWord;
    }

    protected function setMetadata()
    {
        // doc info
        $title = <<<TXT
Laporan Harian {$this->dailyReport->shipbuilding->name} {$this->dailyReport->date->translatedFormat("d M y")}
TXT;
        // doc info
        $description = <<<TXT
Laporan progres harian pembangunan kapal {$this->dailyReport->shipbuilding->name}
pada hari {$this->dailyReport->date->translatedFormat('l, d F Y')}
TXT;
        $properties = $this->phpWord->getDocInfo();
        $properties->setCreator('SIMPRO');
        $properties->setCompany('SBU Marine Services - PT BKI');
        $properties->setTitle(trim($title));
        $properties->setDescription(trim($description));
        $properties->setCategory('SIMPRO');
        $properties->setLastModifiedBy('SIMPRO Application');
        $properties->setSubject($this->dailyReport->shipbuilding->name);
        $properties->setKeywords('Pengawasan Kapal, SBU Marine Services, PT BKI');

        // configs
        $proofState = new ProofState();
        $proofState->setGrammar(ProofState::CLEAN);
        $proofState->setSpelling(ProofState::CLEAN);
        $this->phpWord->getSettings()->setProofState($proofState);
        $this->phpWord->getSettings()->setHideGrammaticalErrors(true);
        $this->phpWord->getSettings()->setHideSpellingErrors(true);
        $this->phpWord->getSettings()->setThemeFontLang(new Language('id-ID'));
        $this->phpWord->getCompatibility()->setOoxmlVersion(16);

        // formatting
        $this->phpWord->setDefaultFontName('Times New Roman');
        $this->phpWord->setDefaultFontSize(12);
        $this->phpWord->addParagraphStyle(
            pCenter,
            ['alignment' => Jc::CENTER]
        );
        $this->phpWord->addParagraphStyle(
            pJustify,
            ['alignment' => Jc::BOTH]
        );
        $this->phpWord->addParagraphStyle(
            pText,
            [
                'alignment' => Jc::BOTH,
                'indentation' => [
                    'left' => Converter::cmToTwip(1),
                ],
                'spaceAfter' => Converter::cmToTwip(0.5),
            ]
        );
        $this->phpWord->addFontStyle(
            fBold,
            ['bold' => true]
        );
        $this->phpWord->addFontStyle(
            fTitle,
            [
                'allCaps' => true,
                'size' => 18,
                'bold' => true,
            ]
        );
        $this->phpWord->addFontStyle(
            fLink,
            ['color' => '000080']
        );
    }

    protected function writeMinutes()
    {
        $section = $this->phpWord->addSection(['pageNumberingStart' => 1]);

        // footer
        $footer = $section->addFooter();
        $footer->addPreserveText('{PAGE} / {SECTIONPAGES}', null, ['alignment' => 'right']);

        // Create a header
        $header = $section->addHeader();
        $table = $header->addTable([
            'alignment' => Jc::CENTER,
            'borderSize' => 0,
            'width' => Converter::cmToTwip(16),
        ]);
        $cellStyle = [
            'borderBottomSize' => 25, // Bold bottom border
            'borderBottomColor' => '000000',
        ];
        $row = $table->addRow();
        $bkiCell = $row->addCell(Converter::cmToTwip(5), $cellStyle);
        $bkiCell->addImage(
            file_get_contents('images/logo/bki-main.jpg'),
            [
                'width' => converter::cmToPoint(2.75),
                'height' => converter::cmToPoint(1.56),
            ]);
        $titleCell = $row->addCell(Converter::cmToTwip(6), $cellStyle);
        $titleCell->addText('Laporan Harian', fBold, pCenter);
        $titleCell->addText('Tanggal ' . $this->dailyReport->date->format('d/m/Y'), fBold, pCenter);
        $bagCell = $row->addCell(Converter::cmToTwip(5), $cellStyle);
        $bagCell->addImage(
            file_get_contents('images/logo/bag.jpg'),
            [
                'width' => converter::cmToPoint(2.58),
                'height' => converter::cmToPoint(1.45),
                'alignment' => Jc::END,
            ]
        );


    }

}
