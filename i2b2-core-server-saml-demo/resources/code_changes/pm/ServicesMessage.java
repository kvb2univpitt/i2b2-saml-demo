/** *****************************************************************************
 * Copyright (c) 2006-2018 Massachusetts General Hospital
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/. I2b2 is also distributed under
 * the terms of the Healthcare Disclaimer.
 ***************************************************************************** */
/*

 *
 * Contributors:
 *     Mike Mendis - initial API and implementation
 *     Kevin V. Bui - added SAML authentication
 */
package edu.harvard.i2b2.pm.ws;

import edu.harvard.i2b2.common.exception.I2B2Exception;
import edu.harvard.i2b2.common.util.jaxb.JAXBUtil;
import edu.harvard.i2b2.common.util.jaxb.JAXBUtilException;
import edu.harvard.i2b2.pm.dao.PMDbDao;
import edu.harvard.i2b2.pm.datavo.i2b2message.BodyType;
import edu.harvard.i2b2.pm.datavo.i2b2message.RequestMessageType;
import edu.harvard.i2b2.pm.datavo.i2b2message.SecurityType;
import edu.harvard.i2b2.pm.services.SessionData;
import edu.harvard.i2b2.pm.util.PMUtil;
import java.util.Iterator;
import javax.servlet.http.HttpServletRequest;
import javax.sql.DataSource;
import javax.xml.bind.JAXBElement;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.dao.DataAccessException;
import org.springframework.jdbc.core.JdbcTemplate;

/**
 * The PatientDataMessage class is a helper class to build PFT messages in the
 * i2b2 format
 */
public class ServicesMessage {

    private static Log log = LogFactory.getLog(ServicesMessage.class);
    //  private JAXBUtil jaxbUtil = null;
    RequestMessageType reqMessageType = null;

    /**
     * The constructor
     */
    public ServicesMessage(String requestPdo, HttpServletRequest req) throws I2B2Exception {
        JAXBUtil jaxbUtil = MessageFactory.getJAXBUtil();
        //new JAXBUtil(JAXBConstant.DEFAULT_PACKAGE_NAME);

        try {
            log.debug("Begin unmarshall of XML");
            JAXBElement jaxbElement = jaxbUtil.unMashallFromString(requestPdo);

            if (jaxbElement == null) {
                throw new I2B2Exception(
                        "Null value from unmashall for PDO xml : " + requestPdo);
            }

            log.debug("Finished unmarshall of XML");
            this.reqMessageType = (RequestMessageType) jaxbElement.getValue();

        } catch (JAXBUtilException e) {
            e.printStackTrace();
            log.error(e.getMessage(), e);
            throw new I2B2Exception("Umashaller error: " + e.getMessage()
                    + requestPdo, e);
        }

        setSamlUserToLocalUser(req);
    }

    private void setSamlUserToLocalUser(HttpServletRequest req) throws I2B2Exception {
        SecurityType credentials = getRequestMessageType().getMessageHeader().getSecurity();
        String username = credentials.getUsername().trim();
        if (username.startsWith("saml:")) {
            String password = credentials.getPassword().getValue();
            String samlUsername = username.replaceAll("saml:", "");
            String samlSessionId = password.replaceAll("saml:", "");
            if (password.startsWith("SessionKey:")) {
                String localUser = lookupUsernameFromSamlUsername(samlUsername);
                String sessionId = password.replaceAll("SessionKey:", "");
                if (verifySessionForSamlUser(localUser, sessionId)) {
                    credentials.setUsername(localUser);
                }
            } else if ((samlUsername.equals(req.getHeader("X-eduPersonPrincipalName"))
                    || samlUsername.equals(req.getHeader("X-eppn")))
                    && samlSessionId.equals(req.getHeader("X-Shib-Session-ID"))) {
                credentials.setUsername(lookupUsernameFromSamlUsername(samlUsername));
            }
        }
    }

    private String lookupUsernameFromSamlUsername(String samlUsername) throws I2B2Exception {
        DataSource dataSource = PMUtil.getInstance().getDataSource("java:/PMBootStrapDS");
        JdbcTemplate jdbcTemplate = new JdbcTemplate(dataSource);
        try {
            String sql = "SELECT user_id FROM pm_user_params WHERE param_name_cd = 'eppn' AND lower(value) = lower(?)";
            return jdbcTemplate.query(sql, ps -> ps.setString(1, samlUsername), rs -> rs.next() ? rs.getString(1) : samlUsername);
        } catch (DataAccessException exception) {
            log.error("Unable to lookup local username using SAML username.", exception);
            return samlUsername;
        }
    }

    private boolean verifySessionForSamlUser(String localUser, String sessionId) throws I2B2Exception {
        SessionData session = null;

        PMDbDao dao = new PMDbDao();
        Iterator it = dao.getSession(localUser, sessionId).iterator();
        while (it.hasNext()) {
            session = (SessionData) it.next();
        }

        return (session != null);
    }

    /**
     * Function to get RequestData object from i2b2 request message type
     *
     * @return
     * @throws JAXBUtilException
     */
    public BodyType getRequestType() throws JAXBUtilException {
        BodyType bodyType = reqMessageType.getMessageBody();
        //   JAXBUnWrapHelper helper = new JAXBUnWrapHelper();
        //  Object requestType =  helper.getObjectByClass(bodyType.getAny(),
//        		GetUserConfigurationType.class);

        return bodyType;
    }


    /*
    public GetUserConfigurationType getRequestType() throws JAXBUtilException {
        BodyType bodyType = reqMessageType.getMessageBody();
        JAXBUnWrapHelper helper = new JAXBUnWrapHelper();
        GetUserConfigurationType requestType = (GetUserConfigurationType) helper.getObjectByClass(bodyType.getAny(),
        		GetUserConfigurationType.class);

        return requestType;
    }
     */
    public RequestMessageType getRequestMessageType() {
        return reqMessageType;
    }
}

