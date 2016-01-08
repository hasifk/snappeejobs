<?php

use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $skills = [
            ".NET Recruiters","3D Max","ABAP","AbInitio","Active Directory","ADaM","ADO","Adobe Illustrator","Adobe Photoshop",
            "Affiliate Marketing","AIX","AJAX","ALE","Android","AngularJS","Ansys","Ant","Apache Tomcat","ASIC","ASP","ASP.NET",
            "ATG","ATL","Auto CAD","Automation Testing","Autosys","BAAN","Back office","Backend","BASIC","Big Data","BizTalk",
            "Blackberry","Bluetooth","Bootstrap","Business Intelligence","Business Objects","C","C#","C++","CAD","CakePHP",
            "Call Center","Calypso","CATIA","CCIE","CCNA","CDMA","CICS","CISCO","Cloud Computing","CMS","COBOL","Codeigniter",
            "Cognos","ColdFusion","Core Java","Corel Draw","Creative","CRM","Crystal Report","CSS","Data Analysis","Data Mining",
            "Data Structures","data warehousing","Database Administration","Database","Datastage","Datawarehousing","DB2","Delphi",
            "DFT","DHCP","DHTML","Digital Marketing","Distribution","DNS","Documentation","Documentum","Dreamweaver","Drupal",
            "DSP","DTP","DWH","Eclipse","Ecommerce","Editing","EJB","Embedded C","ERP","Ethernet","ETL","Excel","Expeditor",
            "FileNet","Finacle","Firewall","Fireworks","Flash","Flex","Flexcube","Focus","FPGA","FTP","GIS","GLOSS","GSM",
            "Hadoop","Hibernate","HP UNIX","HTML","HTML5","Humming Bird","Head Hunting","Hybris","Hyperion","IIS","IMS",
            "Informatica","Information Security","Informix","Internet Marketing","IOS","Iphone","ITIL","J2EE","J2ME","Java",
            "JavaScript","JBoss","JCL","JDBC","JIRA","Jive","JMS","Joomla","JPA","Jquery","JSF","JSON","JSP","JUnit","KSH",
            "LAMP","LAN","Liferay","LINQ","Linux","Load Runner","Lotus Notes","Mac OS","Machine Learning","Magento",
            "Mainframe","Manual Testing","MATLAB","Maven","Maximo","Maya","MCP","MCSA","MCSE","MFC","Microcontrollers",
            "Microprocessors","Microsoft Access","Microsoft Excel","Microsoft Exchange","Microsoft Office","MicroStation",
            "Middleware","MIS","Mobile","MOSS","Motif","MS Project","MS SQL Server","MS Visio","MSBI","MSCIT","Multimedia",
            "Multithreading","Murex","MVC","MySQL","NetWeaver","Networking","Node.js","Novell","OBIEE","ODBC",
            "Office Operations","Online Marketing","OOPS","Open Source","Operating Systems","Oracle Apps","Oracle",
            "Oracle WareHouse Builder","Pega","PeopleSoft","Performance Testing","Perl","Photoshop","PHP","PL/SQL",
            "Plc","PowerBuilder","PPC","Primavera","PRO E","Programming","Progress 4GL","Python","QlikView","QTP",
            "RedHat","Remedy","Ruby on Rails","RWD","Salesforce","SAP abap","SAP Basis","SAP BW","SAP CRM","SAP EP",
            "SAP FICO","SAP HR","SAP IS-Retail","SAP MDM","SAP MM","SAP PM","SAP PP","SAP PS","SAP QM","SAP","SAP SCM",
            "SAP SD","SAP Security","SAP SRM","SAP XI","SAS","Savvion","SCADA","SDET","SDTM","Selenium","SEO","Servlets",
            "SFDC","Sharepoint","Shell Scripting","Siebel","Silverlight","SOA","SOAP","Software Testing","Solaris",
            "Solution Architect","Spring","SPSS","SQL","Struts","Switching","Sybase","System Administrator","Tally",
            "Technical Architect","Teradata","Tibco","UniGraphics","Unix","VB.NET","VC++","Verilog","Video Editing",
            "Virtualization","Vision Plus","Visual Basic","VLSI","Vmware","VOIP","WCF","Web Designing","WebLogic",
            "WebMethods","Website Development","WebSphere","Wordpress","WPF","WTX","XML","Zend","Accounting",
            "Accounts Management","Accounts","Administration","Advertisement Sales","Advertising Account Management",
            "Advertising","Advisory","Analysis","Animation","Aquisitions","Architecture","Art","Astrology","Audit",
            "Authoring","Banking","Biotechnology","Bookkeeping","Branding","Bulk Hiring","Busines Analysis",
            "Business Development","Buying","Cae","CAE","CCE","Channel Account Management","Chartered Accountancy",
            "Coaching","Company Laws","Consulting","Content Writing","Cooking","Copywriting","Corporate Finance",
            "Cost Accounting","Counselling","Credit","Credit Risk","CSA","Csr","Customer Relations","Customer Service",
            "Dance","Data Entry","Design","Direct Sales","Education","Electrical Distribution","Email Marketing",
            "Embedded","Entertainment","EPC","Equity","Event Management","Export Marketing","Film Editing","Finance",
            "Financial Planning","Front Office","Graphic Design","Guest Service","Hiring","Hospitality",
            "Human Resource Management","HVAC","Illustration","Image Consulting","Income Tax","Industrial Designing",
            "Inside Sales","Instructing","Insurance","Interior Design","International Marketing","Investment Banking",
            "IT Recruitment","Jewellery","Journalism","Key Accounts Management","Knowledge Management",
            "Landscape Architecture","Landscape Gardening","Lead Generation","Legal","Lighting","Logistics",
            "Maintenance","Manufacturing","Market Research","Marketing","Mathematical","Medical Billing",
            "Medical Coding","Merchandise","Mergers","Microstrategy","Mining","Music","Negotiating Skill",
            "Negotiation","Nursing","Office Administration","Office Management","Packaging","Payroll",
            "Personal Services","Photography","Physical Design","Planning and Organising","Plumbing","PMP","Pre Sales",
            "Procurement","Producing","Product Management","Production","Program Management","Project Management",
            "Public Relations","Purchase","Quality Assurance","Quality Control","Recruitment","Retail","Risk Management",
            "Sales Accounting","Sales Planning","Sales","Sales Tax","SCM","Screen Printing","Screening","SEM","Semiconductor",
            "Six Sigma","Smo","Sourcing","Space Selling","Staffing","Store planning","Strategic Planning","Supervising",
            "Supply Chain","Talent Acquisition","Tax Audits","Tax Laws","Taxation","Teaching","Technical Support",
            "Telemarketing","Textile Designing","Therapy","Trade Execution","Training","Treasury","UI Designing",
            "Underwriting","Upholstery","Vendor Development","Vendor Management","Visa Expat Management",
            "Visual Merchandising","Voice Process","Waste Management","Wealth Management","Weaving","WFM",
            "Wine making","Writing","Yoga"
        ];

        foreach ($skills as $skill) {
            DB::table( 'skills' )->insert([
                'name'          => $skill,
                'created_at'    => \Carbon\Carbon::now(),
                'updated_at'    => \Carbon\Carbon::now(),
            ]);
        }

    }
}
