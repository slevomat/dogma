<?php declare(strict_types = 1);
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma;

enum ResourceType: string
{

    case Aspell = 'aspell';
    case Bzip2 = 'bzip2';
    case Com = 'COM';
    case Variant = 'VARIANT';
    case Cpdf = 'cpdf';
    case CpdfOutline = 'cpdf outline';
    case CubridConnection = 'cubrid connection';
    case PersistentCubridConnection = 'persistent cubrid connection';
    case CubridRequest = 'cubrid request';
    case CubridLob = 'cubrid lob';
    case CubridLob2 = 'cubrid lob2';
    case Curl = 'curl';
    case Dbm = 'dbm';
    case Dba = 'dba';
    case DbaPersistent = 'dba persistent';
    case Dbase = 'dbase';
    case DbxLinkObject = 'dbx_link_object';
    case DbxResultObject = 'dbx_result_object';
    case XpathContext = 'xpath context';
    case XpathObject = 'xpath object';
    case FbsqlLink = 'fbsql link';
    case FbsqlPlink = 'fbsql plink';
    case FbsqlResult = 'fbsql result';
    case Fdf = 'fdf';
    case Ftp = 'ftp';
    case Gd = 'gd';
    case GdFont = 'gd font';
    case GdPsEncoding = 'gd PS encoding';
    case GdPsFont = 'gd PS font';
    case GmpInteger = 'GMP integer';
    case HyperwaveDocument = 'hyperwave document';
    case HyperwaveLink = 'hyperwave link';
    case HyperwaveLinkPersistent = 'hyperwave link persistent';
    case Icap = 'icap';
    case Imap = 'imap';
    case ImapChainPersistent = 'imap chain persistent';
    case ImapPersistent = 'imap persistent';
    case Ingres = 'ingres';
    case IngresPersistent = 'ingres persistent';
    case InterbaseBlob = 'interbase blob';
    case InterbaseLink = 'interbase link';
    case InterbaseLinkPersistent = 'interbase link persistent';
    case InterbaseQuery = 'interbase query';
    case InterbaseResult = 'interbase result';
    case InterbaseTransaction = 'interbase transaction';
    case Java = 'java';
    case LdapLink = 'ldap link';
    case LdapResult = 'ldap result';
    case LdapResultEntry = 'ldap result entry';
    case Mcal = 'mcal';
    case SwfAction = 'SWFAction';
    case SwfBitmap = 'SWFBitmap';
    case SwfButton = 'SWFButton';
    case SwfDisplayItem = 'SWFDisplayItem';
    case SwfFill = 'SWFFill';
    case SwfFont = 'SWFFont';
    case SwfGradient = 'SWFGradient';
    case SwfMorph = 'SWFMorph';
    case SwfMovie = 'SWFMovie';
    case SwfShape = 'SWFShape';
    case SwfSprite = 'SWFSprite';
    case SwfText = 'SWFText';
    case SwfTextField = 'SWFTextField';
    case MnogosearchAgent = 'mnogosearch agent';
    case MnogosearchResult = 'mnogosearch result';
    case MsqlLink = 'msql link';
    case MsqlLinkPersistent = 'msql link persistent';
    case MsqlQuery = 'msql query';
    case MssqlLink = 'mssql link';
    case MssqlLinkPersistent = 'mssql link persistent';
    case MssqlResult = 'mssql result';
    case MysqlLink = 'mysql link';
    case MysqlLinkPersistent = 'mysql link persistent';
    case MysqlResult = 'mysql result';
    case Oci8Collection = 'oci8 collection';
    case Oci8Connection = 'oci8 connection';
    case Oci8Lob = 'oci8 lob';
    case Oci8Statement = 'oci8 statement';
    case OdbcLink = 'odbc link';
    case OdbcLinkPersistent = 'odbc link persistent';
    case OdbcResult = 'odbc result';
    case BirdstepLink = 'birdstep link';
    case BirdstepResult = 'birdstep result';
    case OpensslKey = 'OpenSSL key';
    case OpensslX509 = 'OpenSSL X.509';
    case PdfDocument = 'pdf document';
    case PdfImage = 'pdf image';
    case PdfObject = 'pdf object';
    case PdfOutline = 'pdf outline';
    case PgsqlLargeObject = 'pgsql large object';
    case PgsqlLink = 'pgsql link';
    case PgsqlLinkPersistent = 'pgsql link persistent';
    case PgsqlResult = 'pgsql result';
    case PgsqlString = 'pgsql string';
    case Printer = 'printer';
    case PrinterBrush = 'printer brush';
    case PrinterFont = 'printer font';
    case PrinterPen = 'printer pen';
    case Pspell = 'pspell';
    case PspellConfig = 'pspell config';
    case SablotronXslt = 'Sablotron XSLT';
    case Shmop = 'shmop';
    case SocketsFileDescriptorSet = 'sockets file descriptor set';
    case SocketsIoVector = 'sockets i/o vector';
    case Stream = 'stream';
    case StreamContext = 'stream-context';
    case Socket = 'socket';
    case SybaseDbLink = 'sybase-db link';
    case SybaseDbLinkPersistent = 'sybase-db link persistent';
    case SybaseDbResult = 'sybase-db result';
    case SybaseCtLink = 'sybase-ct link';
    case SybaseCtLinkPersistent = 'sybase-ct link persistent';
    case SybaseCtResult = 'sybase-ct result';
    case Sysvsem = 'sysvsem';
    case Sysvshm = 'sysvshm';
    case Wddx = 'wddx';
    case Xml = 'xml';
    case Zlib = 'zlib';

}
